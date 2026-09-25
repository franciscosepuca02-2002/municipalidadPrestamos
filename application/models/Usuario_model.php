<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_DB_query_builder $db
 */

class Usuario_model extends CI_Model
{
    public function buscar_por_email($email)
    {
        return $this->db->select('id, nombres, apellidos, email, password, rol, is_active')
            ->where('email', $email)
            ->get('usuarios')
            ->row_array();
    }
}
