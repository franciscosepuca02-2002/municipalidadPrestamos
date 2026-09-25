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

    public function listar()
    {
        return $this->db->select('id, nombres, apellidos, email, rol, is_active, created_at')
            ->order_by('apellidos', 'ASC')
            ->order_by('nombres', 'ASC')
            ->get('usuarios')
            ->result_array();
    }

    public function obtener($id)
    {
        return $this->db->select('id, nombres, apellidos, email, rol, is_active')
            ->where('id', $id)
            ->where('rol', 'encargado')
            ->get('usuarios')
            ->row_array();
    }

    public function email_en_uso($email, $id_excluir = NULL)
    {
        $this->db->where('email', $email);

        if ($id_excluir !== NULL) {
            $this->db->where('id !=', $id_excluir);
        }

        return $this->db->count_all_results('usuarios') > 0;
    }

    public function crear($datos)
    {
        return $this->db->insert('usuarios', $datos);
    }

    public function actualizar($id, $datos)
    {
        return $this->db->where('id', $id)->where('rol', 'encargado')->update('usuarios', $datos);
    }

    public function cambiar_estado($id, $activo)
    {
        return $this->db->where('id', $id)
            ->where('rol', 'encargado')
            ->update('usuarios', array('is_active' => $activo));
    }

    public function obtener_perfil($id)
    {
        return $this->db->select('id, nombres, apellidos, email, rol, is_active, created_at')
            ->where('id', $id)
            ->get('usuarios')
            ->row_array();
    }

    public function password_correcta($id, $clave)
    {
        $fila = $this->db->select('password')
            ->where('id', $id)
            ->get('usuarios')
            ->row_array();

        return $fila !== NULL && password_verify($clave, $fila['password']);
    }

    public function cambiar_password($id, $clave)
    {
        return $this->db->where('id', $id)
            ->update('usuarios', array('password' => password_hash($clave, PASSWORD_DEFAULT)));
    }
}
