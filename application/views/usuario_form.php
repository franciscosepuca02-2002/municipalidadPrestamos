<?php

/**
 * @var string     $nombres
 * @var string     $apellidos
 * @var string     $rol
 * @var string     $activo
 * @var array|null $usuario
 */

// El mismo formulario sirve para crear (sin $usuario) y para editar (con $usuario).
$editando = $usuario !== NULL;

$input = 'mt-2 w-full rounded-lg border border-borde bg-fondo px-4 py-3 text-base text-titulo placeholder:text-texto/40 focus:border-boton focus:bg-white focus:outline-none focus:ring-2 focus:ring-suave';
$label = 'block text-sm font-medium text-titulo';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $editando ? 'Editar usuario' : 'Nuevo usuario' ?> · Préstamos</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
    <script src="<?= base_url('assets/js/menu.js') ?>" defer></script>
</head>

<body class="min-h-screen bg-fondo text-texto antialiased">
    <div class="flex min-h-screen">
        <?php $this->load->view('partials/sidebar.php'); ?>

        <div class="flex flex-1 flex-col">
            <?php $this->load->view('partials/topbar.php'); ?>

            <main class="flex-1 px-4 py-6 sm:px-6 sm:py-8 lg:px-10 lg:py-10">
                <div class="mx-auto max-w-2xl">

                    <a href="<?= site_url('usuarios') ?>" class="text-sm font-semibold text-boton hover:text-hover">&larr; Volver a usuarios</a>

                    <div class="mt-4 rounded-2xl border border-borde bg-white p-6 shadow-xl shadow-titulo/10 sm:p-10">
                        <h2 class="text-2xl font-bold text-titulo sm:text-3xl"><?= $editando ? 'Editar usuario' : 'Nuevo usuario' ?></h2>
                        <p class="mt-1"><?= $editando ? 'Modifica los datos de la cuenta.' : 'Crea una cuenta de encargado. Los administradores solo se crean desde la base de datos.' ?></p>

                        <?= form_open($editando ? 'usuarios/actualizar/' . $usuario['id'] : 'usuarios/guardar', array('class' => 'mt-8 space-y-6')) ?>
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <label for="nombres" class="<?= $label ?>">Nombres</label>
                                <input type="text" id="nombres" name="nombres" value="<?= set_value('nombres', $editando ? $usuario['nombres'] : '') ?>" required class="<?= $input ?>">
                                <?= form_error('nombres') ?>
                            </div>

                            <div>
                                <label for="apellidos" class="<?= $label ?>">Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" value="<?= set_value('apellidos', $editando ? $usuario['apellidos'] : '') ?>" required class="<?= $input ?>">
                                <?= form_error('apellidos') ?>
                            </div>
                        </div>

                        <div>
                            <label for="email" class="<?= $label ?>">Correo electrónico</label>
                            <input type="email" id="email" name="email" value="<?= set_value('email', $editando ? $usuario['email'] : '') ?>" placeholder="nombre@linares.cl" autocomplete="off" required class="<?= $input ?>">
                            <?= form_error('email') ?>
                        </div>

                        <div class="grid gap-6 sm:grid-cols-2">
                            <div>
                                <label for="password" class="<?= $label ?>">Contraseña</label>
                                <input type="password" id="password" name="password" autocomplete="new-password" <?= $editando ? '' : 'required' ?> class="<?= $input ?>">
                                <?= form_error('password') ?>
                            </div>

                            <div>
                                <label for="password_confirmar" class="<?= $label ?>">Repetir contraseña</label>
                                <input type="password" id="password_confirmar" name="password_confirmar" autocomplete="new-password" <?= $editando ? '' : 'required' ?> class="<?= $input ?>">
                                <?= form_error('password_confirmar') ?>
                            </div>
                        </div>

                        <p class="text-sm text-texto/70">
                            <?= $editando ? 'Deja la contraseña en blanco para mantener la actual.' : 'Mínimo 8 caracteres.' ?>
                        </p>

                        <div class="flex flex-col-reverse gap-3 border-t border-borde pt-6 sm:flex-row sm:justify-end">
                            <a href="<?= site_url('usuarios') ?>" class="rounded-xl border border-borde px-8 py-3 text-center font-semibold text-titulo transition-colors hover:bg-suave">Cancelar</a>
                            <button type="submit" class="rounded-xl bg-boton px-8 py-3 font-semibold text-white transition-colors hover:bg-hover"><?= $editando ? 'Guardar cambios' : 'Crear usuario' ?></button>
                        </div>
                        </form>
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>

</html>