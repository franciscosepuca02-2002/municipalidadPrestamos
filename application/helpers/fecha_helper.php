<?php
defined('BASEPATH') or exit('No direct script access allowed');

if ( ! function_exists('fecha_en_palabras')) {
    function fecha_en_palabras($fecha = 'now', $con_dia_semana = FALSE)
    {
        $dias  = array('domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado');
        $meses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
                       'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

        $momento = strtotime($fecha);

        $texto = date('j', $momento) . ' de ' . $meses[date('n', $momento) - 1] . ' de ' . date('Y', $momento);

        if ($con_dia_semana) {
            $texto = $dias[date('w', $momento)] . ' ' . $texto;
        }

        return $texto;
    }
}