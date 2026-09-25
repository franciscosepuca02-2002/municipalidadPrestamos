<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Usuario_model $Usuario_model
 */
class Login extends CI_Controller
{

    public function index()
    {
        if (hay_sesion()) {
            redirect('inicio');
        }

        $this->load->view('login');
    }

    public function validar()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'correo electrónico', 'trim|required|valid_email', array(
            'required'    => 'Ingresa tu %s.',
            'valid_email' => 'El %s no tiene un formato válido.',
        ));
        $this->form_validation->set_rules('password', 'contraseña', 'required', array(
            'required' => 'Ingresa tu %s.',
        ));

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('login');
            return;
        }

        $this->load->model('Usuario_model');
        $usuario = $this->Usuario_model->buscar_por_email($this->input->post('email'));

        if ($usuario === NULL || ! password_verify($this->input->post('password'), $usuario['password'])) {
            $this->load->view('login', array('error' => 'Correo o contraseña incorrectos.'));
            return;
        }

        if (! $usuario['is_active']) {
            $this->load->view('login', array('error' => 'Tu cuenta está desactivada. Contacta al administrador.'));
            return;
        }

        $this->session->sess_regenerate(TRUE);
        $this->session->set_userdata(array(
            'id_usuario' => $usuario['id'],
            'nombres'    => $usuario['nombres'],
            'apellidos'  => $usuario['apellidos'],
            'rol'        => $usuario['rol'],
        ));

        redirect('inicio');
    }
    
    public function salir()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
