<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader  $load
 * @property CI_Session $session
 * @property CI_Input   $input
 * @property CI_Output $output
 * @property Funcionario_model $Funcionario_model
 * @property Item_model $Item_model
 */

class Prestamos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (! hay_sesion()) {
            redirect('login');
        }
    }

    public function index()
    {
        redirect('prestamos/nuevo');
    }

    public function nuevo()
    {
        $datos = array(
            'nombres'   => $this->session->userdata('nombres'),
            'apellidos' => $this->session->userdata('apellidos'),
            'rol'       => $this->session->userdata('rol'),
            'activo'    => 'prestamos',
        );

        $this->load->view('prestamos_form', $datos);
    }
    public function guardar()
    { /* recibe el POST */
    }

    public function buscar_funcionario()
    {
        $this->load->model('Funcionario_model');

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($this->Funcionario_model->buscar_por_rut($this->input->get('rut'))));
    }

    public function buscar_item()
    {
        $this->load->model('Item_model');

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($this->Item_model->buscar_por_identificador($this->input->get('q'))));
    }
}
