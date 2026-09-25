<?php

/**
 * @var string $nombres
 * @var string $apellidos
 * @var string $rol
 * @var string $activo
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil · Préstamos</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
    <script src="<?= base_url('assets/js/menu.js') ?>" defer></script>
    <script src="<?= base_url('assets/js/mostrar-clave.js') ?>" defer></script>
</head>

<body class="min-h-screen bg-fondo text-texto antialiased">
    <div class="flex min-h-screen">
        <?php $this->load->view('partials/sidebar.php'); ?>

        <div class="flex flex-1 flex-col">
            <?php $this->load->view('partials/topbar.php'); ?>

            <main class="flex-1 px-4 py-6 sm:px-6 sm:py-8 lg:px-10 lg:py-10">
                <?php $this->load->view('partials/perfil_contenido'); ?>
            </main>
        </div>
    </div>
</body>

</html>