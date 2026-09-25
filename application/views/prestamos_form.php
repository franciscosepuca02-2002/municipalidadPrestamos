<?php

/**
 * @var string $nombres
 * @var string $apellidos
 * @var string $rol
 * @var string $activo
 */

// Clases repetidas, para no ensuciar el marcado más abajo.
$input = 'w-full rounded-lg border border-borde bg-white px-4 py-2.5 text-texto placeholder:text-texto/40 focus:border-boton focus:outline-none focus:ring-2 focus:ring-boton/30';
$label = 'mb-1.5 block text-sm font-semibold text-titulo';
$th    = 'px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-titulo';
$td    = 'px-4 py-3 align-middle';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo préstamo · Préstamos</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
    <script src="<?= base_url('assets/js/menu.js') ?>" defer></script>
    <!-- Se activa en el paso del JavaScript -->
    <!-- <script src="<?= base_url('assets/js/prestamo.js') ?>" defer></script> -->
</head>

<body class="min-h-screen bg-fondo text-texto antialiased">
    <div class="flex min-h-screen">
        <?php $this->load->view('partials/sidebar.php'); ?>

        <div class="flex flex-1 flex-col">
            <?php $this->load->view('partials/topbar.php'); ?>

            <main class="flex-1 px-4 py-6 sm:px-6 sm:py-8 lg:px-10 lg:py-10">
                <div class="mx-auto max-w-5xl">

                    <?= form_open('prestamos/guardar') ?>

                    <div class="rounded-2xl border border-borde bg-white p-6 shadow-xl shadow-titulo/10 sm:p-8 lg:p-10">

                        <h2 class="text-2xl font-bold text-titulo sm:text-3xl">Acta de Entrega de Equipos</h2>

                        <?php if (validation_errors()) : ?>
                            <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                                <?= validation_errors() ?>
                            </div>
                        <?php endif; ?>

                        <!-- ============ 1. FUNCIONARIO ============ -->
                        <div class="mt-8 flex items-center gap-4">
                            <h3 class="shrink-0 text-sm font-bold uppercase tracking-wide text-titulo">1. Información del funcionario</h3>
                            <span class="h-px flex-1 bg-borde"></span>
                        </div>

                        <input type="hidden" name="id_funcionario" id="id_funcionario" value="<?= set_value('id_funcionario') ?>">

                        <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                            <div>
                                <label for="rut" class="<?= $label ?>">RUT</label>
                                <div class="relative">
                                    <input type="text" name="rut" id="rut" value="<?= set_value('rut') ?>"
                                        placeholder="12345678-9" autocomplete="off"
                                        class="<?= $input ?> pr-12">
                                    <button type="button" id="buscar-funcionario" aria-label="Buscar funcionario"
                                        class="absolute inset-y-0 right-0 flex w-11 items-center justify-center rounded-r-lg border-l border-borde text-texto transition-colors hover:bg-suave">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="tratamiento" class="<?= $label ?>">Tratamiento</label>
                                <select name="tratamiento" id="tratamiento" class="<?= $input ?>">
                                    <option value="Sr." <?= set_select('tratamiento', 'Sr.', TRUE) ?>>Sr.</option>
                                    <option value="Sra." <?= set_select('tratamiento', 'Sra.') ?>>Sra.</option>
                                </select>
                            </div>

                            <div>
                                <label for="nombres" class="<?= $label ?>">Nombres</label>
                                <input type="text" name="nombres" id="nombres" value="<?= set_value('nombres') ?>" class="<?= $input ?>">
                            </div>

                            <div>
                                <label for="apellidos" class="<?= $label ?>">Apellidos</label>
                                <input type="text" name="apellidos" id="apellidos" value="<?= set_value('apellidos') ?>" class="<?= $input ?>">
                            </div>

                            <div class="sm:col-span-2 lg:col-span-3">
                                <label for="cargo_departamento" class="<?= $label ?>">Cargo / Departamento</label>
                                <input type="text" name="cargo_departamento" id="cargo_departamento" value="<?= set_value('cargo_departamento') ?>" class="<?= $input ?>">
                            </div>

                            <div>
                                <label for="fecha" class="<?= $label ?>">Fecha del acta</label>
                                <input type="date" name="fecha" id="fecha" value="<?= set_value('fecha', date('Y-m-d')) ?>" class="<?= $input ?>">
                            </div>
                        </div>

                        <!-- ============ 2. EQUIPOS ============ -->
                        <div class="mt-10 flex items-center gap-4">
                            <h3 class="shrink-0 text-sm font-bold uppercase tracking-wide text-titulo">2. Equipos a entregar</h3>
                            <span class="h-px flex-1 bg-borde"></span>
                        </div>

                        <div class="mt-5 rounded-xl bg-fondo p-5">
                            <label for="buscar-item" class="<?= $label ?>">Buscar equipo</label>
                            <div class="flex flex-col gap-3 sm:flex-row">
                                <input type="text" id="buscar-item" autocomplete="off"
                                    placeholder="N° inventario, N° de serie, MAC o IMEI"
                                    class="<?= $input ?> flex-1">
                                <button type="button" id="agregar-item"
                                    class="shrink-0 rounded-lg bg-boton px-6 py-2.5 font-semibold text-white transition-colors hover:bg-hover">
                                    + Agregar equipo
                                </button>
                            </div>
                            <p class="mt-2 text-xs text-texto/60">Si el equipo no está registrado, se crea con los datos que escribas en la fila.</p>
                        </div>

                        <div class="mt-5 overflow-x-auto rounded-xl border border-borde">
                            <table class="w-full min-w-[56rem] border-collapse text-sm">
                                <thead class="bg-suave">
                                    <tr>
                                        <th class="<?= $th ?>">N° Inventario</th>
                                        <th class="<?= $th ?>">Marca</th>
                                        <th class="<?= $th ?>">Modelo</th>
                                        <th class="<?= $th ?>">N° Serie (SN)</th>
                                        <th class="<?= $th ?>">MAC / IMEI</th>
                                        <th class="<?= $th ?>">Observaciones</th>
                                        <th class="<?= $th ?> text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-items" class="divide-y divide-borde">

                                    <!-- FILAS DE EJEMPLO: las borras cuando entre el JavaScript -->
                                    <tr>
                                        <td class="<?= $td ?> font-semibold text-titulo">
                                            <input type="hidden" name="items[0][id_item]" value="11">
                                            INV-2026-041
                                        </td>
                                        <td class="<?= $td ?>">Lenovo</td>
                                        <td class="<?= $td ?>">ThinkPad T14s G4</td>
                                        <td class="<?= $td ?>">PF4892LK-91</td>
                                        <td class="<?= $td ?>">00:1A:2B:3C:4D:5E</td>
                                        <td class="<?= $td ?>">
                                            <input type="text" name="items[0][observacion]" placeholder="Cargador, funda…" class="<?= $input ?> py-1.5 text-sm">
                                        </td>
                                        <td class="<?= $td ?> text-center">
                                            <button type="button" class="quitar-item rounded-lg bg-red-50 px-3 py-1.5 font-bold text-red-600 transition-colors hover:bg-red-100" aria-label="Quitar equipo">&times;</button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="<?= $td ?> font-semibold text-titulo">
                                            <input type="hidden" name="items[1][id_item]" value="12">
                                            INV-2026-088
                                        </td>
                                        <td class="<?= $td ?>">Samsung</td>
                                        <td class="<?= $td ?>">Galaxy S23 FE</td>
                                        <td class="<?= $td ?>">R58M3490XW2</td>
                                        <td class="<?= $td ?>">358901234567</td>
                                        <td class="<?= $td ?>">
                                            <input type="text" name="items[1][observacion]" placeholder="Cargador, funda…" class="<?= $input ?> py-1.5 text-sm">
                                        </td>
                                        <td class="<?= $td ?> text-center">
                                            <button type="button" class="quitar-item rounded-lg bg-red-50 px-3 py-1.5 font-bold text-red-600 transition-colors hover:bg-red-100" aria-label="Quitar equipo">&times;</button>
                                        </td>
                                    </tr>

                                    <tr id="fila-vacia" class="hidden">
                                        <td colspan="7" class="px-4 py-10 text-center text-texto/50">Todavía no has agregado equipos.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- ============ OBSERVACIÓN GENERAL ============ -->
                        <div class="mt-8">
                            <label for="observacion" class="<?= $label ?>">Observación general <span class="font-normal text-texto/50">(opcional)</span></label>
                            <textarea name="observacion" id="observacion" rows="2" class="<?= $input ?>"><?= set_value('observacion') ?></textarea>
                        </div>

                        <!-- ============ BOTONES ============ -->
                        <div class="mt-10 flex flex-col-reverse gap-3 border-t border-borde pt-6 sm:flex-row sm:justify-end">
                            <a href="<?= site_url('inicio') ?>"
                                class="rounded-xl border border-borde px-8 py-3 text-center font-semibold text-titulo transition-colors hover:bg-suave">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="rounded-xl bg-boton px-8 py-3 font-semibold text-white transition-colors hover:bg-hover">
                                Guardar Acta
                            </button>
                        </div>

                    </div>

                    <?= form_close() ?>

                </div>
            </main>
        </div>
    </div>

    <!-- Plantilla para las filas que agregue el JavaScript. No se renderiza. -->
    <template id="plantilla-item">
        <tr>
            <td class="<?= $td ?> font-semibold text-titulo">
                <input type="hidden" name="items[__i__][id_item]" data-campo="id_item">
                <span data-campo="numero_inventario"></span>
            </td>
            <td class="<?= $td ?>" data-campo="marca"></td>
            <td class="<?= $td ?>" data-campo="modelo"></td>
            <td class="<?= $td ?>" data-campo="sn"></td>
            <td class="<?= $td ?>" data-campo="mac_imei"></td>
            <td class="<?= $td ?>">
                <input type="text" name="items[__i__][observacion]" placeholder="Cargador, funda…" class="<?= $input ?> py-1.5 text-sm">
            </td>
            <td class="<?= $td ?> text-center">
                <button type="button" class="quitar-item rounded-lg bg-red-50 px-3 py-1.5 font-bold text-red-600 transition-colors hover:bg-red-100" aria-label="Quitar equipo">&times;</button>
            </td>
        </tr>
    </template>
</body>

</html>