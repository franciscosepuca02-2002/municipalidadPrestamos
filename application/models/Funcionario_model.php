<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */
class Funcionario_model extends CI_Model
{
    public function buscar_por_rut($rut)
    {
        $rut = normalizar_rut($rut);

        if ($rut === '') {
            return NULL;
        }

        return $this->db
            ->where('rut', $rut)
            ->get('funcionarios')
            ->row_array();
    }

    public function obtener($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('funcionarios')
            ->row_array();
    }

    public function crear($datos)
    {
        $this->db->insert('funcionarios', array(
            'rut'                => normalizar_rut($datos['rut']) ?: NULL,
            'nombres'            => trim($datos['nombres']),
            'apellidos'          => trim($datos['apellidos']),
            'cargo_departamento' => trim($datos['cargo_departamento']),
        ));

        return $this->db->insert_id();
    }
}
