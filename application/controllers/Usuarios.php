<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader          $load
 * @property CI_Session         $session
 * @property CI_Input           $input
 * @property CI_Form_validation $form_validation
 * @property Usuario_model      $Usuario_model
 */
class Usuarios extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (! hay_sesion()) {
            redirect('login');
        }

        if (! es_admin()) {
            redirect('inicio');
        }

        $this->load->model('Usuario_model');
    }

    public function index()
    {
        $this->load->view('usuarios', $this->datos_vista(array(
            'usuarios' => $this->Usuario_model->listar(),
            'exito'    => $this->session->flashdata('exito'),
        )));
    }

    public function nuevo()
    {
        $this->load->view('usuario_form', $this->datos_vista(array(
            'usuario' => NULL,
        )));
    }

    public function guardar()
    {
        if (! $this->validar_formulario()) {
            $this->nuevo();
            return;
        }

        $this->Usuario_model->crear(array(
            'nombres'   => $this->input->post('nombres'),
            'apellidos' => $this->input->post('apellidos'),
            'email'     => $this->input->post('email'),
            'rol'       => 'encargado',
            'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        ));

        $this->session->set_flashdata('exito', 'Usuario creado correctamente.');

        redirect('usuarios');
    }

    public function editar($id = NULL)
    {
        $usuario = $this->Usuario_model->obtener($id);

        if ($usuario === NULL) {
            show_404();
        }

        $this->load->view('usuario_form', $this->datos_vista(array(
            'usuario' => $usuario,
        )));
    }

    public function actualizar($id = NULL)
    {
        if ($this->Usuario_model->obtener($id) === NULL) {
            show_404();
        }

        if (! $this->validar_formulario($id)) {
            $this->editar($id);
            return;
        }

        $datos = array(
            'nombres'   => $this->input->post('nombres'),
            'apellidos' => $this->input->post('apellidos'),
            'email'     => $this->input->post('email'),
        );

        // Solo se cambia la contraseña si escribieron una nueva.
        if ($this->input->post('password') !== '') {
            $datos['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        $this->Usuario_model->actualizar($id, $datos);

        $this->session->set_flashdata('exito', 'Usuario actualizado correctamente.');

        redirect('usuarios');
    }

    public function cambiar_estado()
    {
        $id     = $this->input->post('id');
        $activo = (int) $this->input->post('activo') === 1 ? 1 : 0;

        if ($this->Usuario_model->obtener($id) === NULL) {
            show_404();
        }

        $this->Usuario_model->cambiar_estado($id, $activo);

        $this->session->set_flashdata('exito', $activo ? 'Usuario activado.' : 'Usuario desactivado.');

        redirect('usuarios');
    }

    private function validar_formulario($id = NULL)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="mt-1.5 text-sm text-red-600">', '</p>');

        $this->form_validation->set_rules('nombres', 'nombres', 'trim|required|max_length[100]', array(
            'required'   => 'Ingresa los %s.',
            'max_length' => 'Los {field} no pueden tener más de {param} caracteres.',
        ));

        $this->form_validation->set_rules('apellidos', 'apellidos', 'trim|required|max_length[100]', array(
            'required'   => 'Ingresa los %s.',
            'max_length' => 'Los {field} no pueden tener más de {param} caracteres.',
        ));

        $this->form_validation->set_rules('email', 'correo electrónico', array(
            'trim',
            'required',
            'valid_email',
            'max_length[100]',
            array('email_disponible', function ($email) use ($id) {
                return ! $this->Usuario_model->email_en_uso($email, $id);
            }),
        ), array(
            'required'         => 'Ingresa el %s.',
            'valid_email'      => 'El %s no tiene un formato válido.',
            'max_length'       => 'El {field} no puede tener más de {param} caracteres.',
            'email_disponible' => 'Ese correo ya lo usa otra cuenta.',
        ));

        // Al crear, la contraseña es obligatoria. Al editar, solo si escribieron una nueva.
        if ($id === NULL || $this->input->post('password') !== '') {
            $this->form_validation->set_rules('password', 'contraseña', 'required|min_length[8]', array(
                'required'   => 'Ingresa una %s.',
                'min_length' => 'La {field} debe tener al menos {param} caracteres.',
            ));

            $this->form_validation->set_rules('password_confirmar', 'repetir contraseña', 'required|matches[password]', array(
                'required' => 'Repite la contraseña.',
                'matches'  => 'Las contraseñas no coinciden.',
            ));
        }

        return $this->form_validation->run();
    }

    private function datos_vista($extra = array())
    {
        return array_merge(array(
            'nombres'   => $this->session->userdata('nombres'),
            'apellidos' => $this->session->userdata('apellidos'),
            'rol'       => $this->session->userdata('rol'),
            'activo'    => 'usuarios',
        ), $extra);
    }
}
