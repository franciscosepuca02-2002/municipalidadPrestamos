<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader  $load
 * @property CI_Session $session
 */
class Inicio extends CI_Controller
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
        $datos = array(
            'nombres'   => $this->session->userdata('nombres'),
            'apellidos' => $this->session->userdata('apellidos'),
            'rol'       => $this->session->userdata('rol'),
            'fecha'     => fecha_en_palabras('now', TRUE),
        );

        $this->load->view('inicio', $datos);
    }
}
