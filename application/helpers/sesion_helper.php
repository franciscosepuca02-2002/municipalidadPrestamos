<?php
defined('BASEPATH') or exit('No direct script access allowed');

if ( ! function_exists('hay_sesion')) {
    function hay_sesion()
    {
        $CI =& get_instance();

        /** @disregard P1014 CodeIgniter crea $session en tiempo de ejecución */
        return $CI->session->userdata('id_usuario') !== NULL;
    }
}

if ( ! function_exists('rol_usuario')) {
    function rol_usuario()
    {
        $CI =& get_instance();

        /** @disregard P1014 CodeIgniter crea $session en tiempo de ejecución */
        return $CI->session->userdata('rol');
    }
}

if ( ! function_exists('es_admin')) {
    function es_admin()
    {
        return rol_usuario() === 'administrador';
    }
}