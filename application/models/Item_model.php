<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */
class Item_model extends CI_Model
{
    /** Columnas que se pueden escribir desde el formulario. */
    private $campos = array('numero_inventario', 'marca', 'modelo', 'sn', 'mac_imei');

    /**
     * Busca por cualquiera de los tres identificadores únicos.
     * Devuelve como máximo una fila, porque las tres columnas son UNIQUE.
     */
    public function buscar_por_identificador($texto)
    {
        $texto = trim((string) $texto);

        if ($texto === '') {
            return NULL;
        }

        return $this->db
            ->group_start()
            ->where('numero_inventario', $texto)
            ->or_where('sn', $texto)
            ->or_where('mac_imei', $texto)
            ->group_end()
            ->get('items')
            ->row_array();
    }

    public function obtener($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('items')
            ->row_array();
    }

    public function crear($datos)
    {
        $fila = array();

        foreach ($this->campos as $campo) {
            $fila[$campo] = isset($datos[$campo]) ? $this->nulo_si_vacio($datos[$campo]) : NULL;
        }

        $this->db->insert('items', $fila);

        return $this->db->insert_id();
    }

    /** Los campos en blanco tienen que guardarse como NULL, no como ''. */
    private function nulo_si_vacio($valor)
    {
        $valor = trim((string) $valor);

        return $valor === '' ? NULL : $valor;
    }
}
