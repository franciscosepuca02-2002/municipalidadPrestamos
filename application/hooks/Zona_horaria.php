<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Zona_horaria
{
    public function set()
    {
        $CI = &get_instance();

        // date('P') devuelve el desfase actual, "-03:00" o "-04:00" según
        // si estamos en horario de verano. MySQL acepta ese formato.
        $CI->db->query('SET time_zone = ' . $CI->db->escape(date('P')));
    }
}
