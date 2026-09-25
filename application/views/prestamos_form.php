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
$tr     = 'mb-4 block rounded-xl border border-borde p-4 md:mb-0 md:table-row md:rounded-none md:border-0 md:p-0';
$td     = 'flex items-center justify-between gap-3 border-b border-borde/50 py-2.5 md:table-cell md:border-0 md:px-4 md:py-3';
$rotulo = 'shrink-0 text-xs font-bold uppercase tracking-wide text-titulo md:hidden';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo préstamo · Préstamos</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
    <script src="<?= base_url('assets/js/menu.js') ?>" defer></script>
    <script src="<?= base_url('assets/js/prestamo.js') ?>" defer></script>
</head>

<body class="min-h-screen bg-fondo text-texto antialiased">
    <div class="flex min-h-screen">
        <?php $this->load->view('partials/sidebar.php'); ?>

        <div class="flex flex-1 flex-col">
            <?php $this->load->view('partials/topbar.php'); ?>

            <main class="flex-1 px-4 py-6 sm:px-6 sm:py-8 lg:px-10 lg:py-10">
                <div class="mx-auto max-w-5xl">

                    <?= form_open('prestamos/guardar', array(
                        'id'                   => 'form-prestamo',
                        'data-url-funcionario' => site_url('prestamos/buscar_funcionario'),
                        'data-url-item'        => site_url('prestamos/buscar_item'),
                    )) ?>

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
                                <label for="nombres" class="<?= $label ?>">Nombres</label>
                                <input type="text" name="nombres" id="nombres" value="<?= set_value('nombres') ?>" class="<?= $input ?>">
                            </div>

                            <div>
                                <label for="apellidos" class="<?= $label ?>">Apellidos</label>
                                <input type="text" name="apellidos" id="apellidos" value="<?= set_value('apellidos') ?>" class="<?= $input ?>">
                            </div>

                            <div>
                                <label for="cargo_departamento" class="<?= $label ?>">Cargo / Departamento</label>
                                <input type="text" name="cargo_departamento" id="cargo_departamento" value="<?= set_value('cargo_departamento') ?>" class="<?= $input ?>">
                            </div>
                        </div>

                        <p class="mt-4 text-sm text-texto/70">
                            El acta se emitirá con fecha <span class="font-semibold text-titulo"><?= fecha_en_palabras() ?></span>.
                        </p>
                        <p id="aviso-funcionario" class="mt-3 hidden text-sm"></p>

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
                                <button type="button" id="agregar-manual"
                                    class="shrink-0 rounded-lg border border-boton px-6 py-2.5 font-semibold text-boton transition-colors hover:bg-suave">
                                    Ingresar manualmente
                                </button>
                            </div>
                            <p id="aviso-item" class="mt-2 text-xs text-texto/60">Busca el equipo por cualquiera de sus identificadores. Si no está registrado o no tiene ninguno, ingrésalo manualmente.</p>
                        </div>

                        <div class="mt-5 md:overflow-x-auto md:rounded-xl md:border md:border-borde">
                            <table class="block w-full border-collapse text-sm md:table md:min-w-[56rem]">
                                <thead class="hidden bg-suave md:table-header-group">
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
                                <tbody id="tabla-items" class="block md:table-row-group md:divide-y md:divide-borde">
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
        <tr class="<?= $tr ?>">
            <td class="<?= $td ?>">
                <span class="<?= $rotulo ?>">N° Inventario</span>
                <input type="hidden" name="items[__i__][id_item]" data-campo="id_item">
                <span class="font-semibold text-titulo" data-campo="numero_inventario"></span>
            </td>
            <td class="<?= $td ?>">
                <span class="<?= $rotulo ?>">Marca</span>
                <span data-campo="marca"></span>
            </td>
            <td class="<?= $td ?>">
                <span class="<?= $rotulo ?>">Modelo</span>
                <span data-campo="modelo"></span>
            </td>
            <td class="<?= $td ?>">
                <span class="<?= $rotulo ?>">N° Serie</span>
                <span data-campo="sn"></span>
            </td>
            <td class="<?= $td ?>">
                <span class="<?= $rotulo ?>">MAC / IMEI</span>
                <span data-campo="mac_imei"></span>
            </td>
            <td class="<?= $td ?>">
                <span class="<?= $rotulo ?>">Observaciones</span>
                <input type="text" name="items[__i__][observacion]" placeholder="Cargador, funda…"
                    class="<?= $input ?> flex-1 py-1.5 text-sm md:w-full">
            </td>
            <td class="block pt-3 md:table-cell md:px-4 md:py-3 md:text-center">
                <button type="button"
                    class="quitar-item w-full rounded-lg bg-red-50 px-3 py-2 font-semibold text-red-600 transition-colors hover:bg-red-100 md:w-auto md:py-1.5 md:font-bold">
                    <span class="md:hidden">Quitar equipo</span>
                    <span class="hidden md:inline">&times;</span>
                </button>
            </td>
        </tr>
    </template>

    <!-- Fila para un equipo que todavía no existe en la base -->
    <template id="plantilla-item-nuevo">
        <tr class="<?= $tr ?> border-boton/40 md:bg-suave/30" data-nuevo="1">
            <td class="<?= $td ?>">
                <span class="<?= $rotulo ?>">N° Inventario</span>
                <input type="hidden" name="items[__i__][id_item]" value="">
                <input type="text" name="items[__i__][numero_inventario]" placeholder="INV-…"
                    class="<?= $input ?> flex-1 py-1.5 text-sm md:w-full">
            </td>
            <td class="<?= $td ?>">
                <span class="<?= $rotulo ?>">Marca</span>
                <input type="text" name="items[__i__][marca]" class="<?= $input ?> flex-1 py-1.5 text-sm md:w-full">
            </td>
            <td class="<?= $td ?>">
                <span class="<?= $rotulo ?>">Modelo</span>
                <input type="text" name="items[__i__][modelo]" class="<?= $input ?> flex-1 py-1.5 text-sm md:w-full">
            </td>
            <td class="<?= $td ?>">
                <span class="<?= $rotulo ?>">N° Serie</span>
                <input type="text" name="items[__i__][sn]" class="<?= $input ?> flex-1 py-1.5 text-sm md:w-full">
            </td>
            <td class="<?= $td ?>">
                <span class="<?= $rotulo ?>">MAC / IMEI</span>
                <input type="text" name="items[__i__][mac_imei]" class="<?= $input ?> flex-1 py-1.5 text-sm md:w-full">
            </td>
            <td class="<?= $td ?>">
                <span class="<?= $rotulo ?>">Observaciones</span>
                <input type="text" name="items[__i__][observacion]" placeholder="Cargador, funda…"
                    class="<?= $input ?> flex-1 py-1.5 text-sm md:w-full">
            </td>
            <td class="block pt-3 md:table-cell md:px-4 md:py-3 md:text-center">
                <button type="button"
                    class="quitar-item w-full rounded-lg bg-red-50 px-3 py-2 font-semibold text-red-600 transition-colors hover:bg-red-100 md:w-auto md:py-1.5 md:font-bold">
                    <span class="md:hidden">Quitar equipo</span>
                    <span class="hidden md:inline">&times;</span>
                </button>
            </td>
        </tr>
    </template>
</body>

</html>