<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (! function_exists('normalizar_rut')) {
    /**
     * Deja siempre el mismo formato: sin puntos, con guion y la K en mayúscula.
     * "12.345.678-k" y "123456789" quedan los dos como "12345678-9" / "12345678-K".
     */
    function normalizar_rut($rut)
    {
        $rut = strtoupper(trim((string) $rut));
        $rut = str_replace(array('.', ' '), '', $rut);

        if ($rut !== '' && strpos($rut, '-') === FALSE) {
            $rut = substr($rut, 0, -1) . '-' . substr($rut, -1);
        }

        return $rut;
    }
}
