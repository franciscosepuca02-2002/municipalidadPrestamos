<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader          $load
 * @property CI_Session         $session
 * @property CI_Input           $input
 * @property CI_Form_validation $form_validation
 * @property Usuario_model      $Usuario_model
 */
class Perfil extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (! hay_sesion()) {
            redirect('login');
        }

        $this->load->model('Usuario_model');
    }

    public function index()
    {
        $this->load->view('perfil', array(
            'nombres'   => $this->session->userdata('nombres'),
            'apellidos' => $this->session->userdata('apellidos'),
            'rol'       => $this->session->userdata('rol'),
            'activo'    => 'perfil',
            'perfil'    => $this->perfil_actual(),
            'exito'     => $this->session->flashdata('exito'),
        ));
    }

    public function cambiar_password()
    {
        $id = $this->perfil_actual()['id'];

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="mt-1.5 text-sm text-red-600">', '</p>');

        $this->form_validation->set_rules('password_actual', 'contraseña actual', array(
            'required',
            array('password_correcta', function ($clave) use ($id) {
                return $this->Usuario_model->password_correcta($id, $clave);
            }),
        ), array(
            'required'          => 'Ingresa tu contraseña actual.',
            'password_correcta' => 'La contraseña actual no es correcta.',
        ));

        $this->form_validation->set_rules('password', 'nueva contraseña', 'required|min_length[8]|differs[password_actual]', array(
            'required'   => 'Ingresa la nueva contraseña.',
            'min_length' => 'La {field} debe tener al menos {param} caracteres.',
            'differs'    => 'La {field} tiene que ser distinta de la actual.',
        ));

        if ($this->form_validation->run() === FALSE) {
            $this->index();
            return;
        }

        $this->Usuario_model->cambiar_password($id, $this->input->post('password'));

        $this->session->set_flashdata('exito', 'Tu contraseña se actualizó correctamente.');

        redirect('perfil');
    }

    private function perfil_actual()
    {
        $perfil = $this->Usuario_model->obtener_perfil($this->session->userdata('id_usuario'));

        if ($perfil === NULL) {
            $this->session->sess_destroy();
            redirect('login');
        }

        return $perfil;
    }
}
