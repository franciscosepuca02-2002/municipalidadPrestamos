<?php

/**
 * @var string $nombres
 * @var string $apellidos
 * @var string $rol
 * @var string $activo
 * @var array  $usuarios
 * @var string|null $exito
 */

// Base de las etiquetas de rol y estado, para no repetirla.
$etiqueta = 'inline-flex rounded-full px-3 py-1 text-xs font-semibold';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios · Préstamos</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
    <script src="<?= base_url('assets/js/menu.js') ?>" defer></script>
</head>

<body class="min-h-screen bg-fondo text-texto antialiased">
    <div class="flex min-h-screen">
        <?php $this->load->view('partials/sidebar.php'); ?>

        <div class="flex flex-1 flex-col">
            <?php $this->load->view('partials/topbar.php'); ?>

            <main class="flex-1 px-4 py-6 sm:px-6 sm:py-8 lg:px-10 lg:py-10">
                <div class="mx-auto max-w-5xl">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-titulo sm:text-3xl">Usuarios</h2>
                            <p class="mt-1">Cuentas con acceso al sistema.</p>
                        </div>
                        <a href="<?= site_url('usuarios/nuevo') ?>" class="rounded-xl bg-boton px-6 py-3 text-center font-semibold text-white transition-colors hover:bg-hover">+ Nuevo usuario</a>
                    </div>

                    <?php if ($exito) : ?>
                        <div role="status" class="mt-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"><?= html_escape($exito) ?></div>
                    <?php endif; ?>

                    <?php if (empty($usuarios)) : ?>

                        <div class="mt-8 rounded-2xl border border-borde bg-white p-10 text-center shadow-xl shadow-titulo/10">
                            <p class="text-texto/60">Todavía no hay usuarios registrados.</p>
                        </div>

                    <?php else : ?>

                        <!-- Celular y tablet: una tarjeta por usuario -->
                        <div class="mt-8 space-y-4 lg:hidden">
                            <?php foreach ($usuarios as $u) : ?>
                                <div class="rounded-2xl border border-borde bg-white p-5 shadow-sm">
                                    <p class="font-semibold text-titulo"><?= html_escape($u['nombres'] . ' ' . $u['apellidos']) ?></p>
                                    <p class="break-all text-sm"><?= html_escape($u['email']) ?></p>

                                    <div class="mt-3 flex flex-wrap items-center gap-2">
                                        <span class="<?= $etiqueta ?> <?= $u['rol'] === 'administrador' ? 'bg-boton text-white' : 'bg-suave text-titulo' ?>"><?= html_escape(ucfirst($u['rol'])) ?></span>
                                        <span class="<?= $etiqueta ?> <?= $u['is_active'] ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' ?>"><?= $u['is_active'] ? 'Activo' : 'Inactivo' ?></span>
                                        <span class="text-xs text-texto/60">Desde <?= date('d/m/Y', strtotime($u['created_at'])) ?></span>
                                    </div>

                                    <div class="mt-4 border-t border-borde pt-3">
                                        <?php $this->load->view('partials/usuario_acciones', array('u' => $u)); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Computador: tabla -->
                        <div class="mt-8 hidden overflow-hidden rounded-2xl border border-borde bg-white shadow-xl shadow-titulo/10 lg:block">
                            <table class="w-full text-sm">
                                <thead class="bg-suave text-left text-xs font-bold uppercase tracking-wide text-titulo">
                                    <tr>
                                        <th class="px-6 py-4">Usuario</th>
                                        <th class="px-6 py-4">Rol</th>
                                        <th class="px-6 py-4">Estado</th>
                                        <th class="px-6 py-4">Creado</th>
                                        <th class="px-6 py-4 text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-borde">
                                    <?php foreach ($usuarios as $u) : ?>
                                        <tr class="transition-colors hover:bg-fondo">
                                            <td class="px-6 py-4">
                                                <p class="font-semibold text-titulo"><?= html_escape($u['nombres'] . ' ' . $u['apellidos']) ?></p>
                                                <p class="text-texto/70"><?= html_escape($u['email']) ?></p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="<?= $etiqueta ?> <?= $u['rol'] === 'administrador' ? 'bg-boton text-white' : 'bg-suave text-titulo' ?>"><?= html_escape(ucfirst($u['rol'])) ?></span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="<?= $etiqueta ?> <?= $u['is_active'] ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' ?>"><?= $u['is_active'] ? 'Activo' : 'Inactivo' ?></span>
                                            </td>
                                            <td class="px-6 py-4"><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                                            <td class="px-6 py-4">
                                                <?php $this->load->view('partials/usuario_acciones', array('u' => $u)); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    <?php endif; ?>

                </div>
            </main>
        </div>
    </div>
</body>

</html>