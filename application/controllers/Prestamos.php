<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader  $load
 * @property CI_Session $session
 * @property CI_Input   $input
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
}
