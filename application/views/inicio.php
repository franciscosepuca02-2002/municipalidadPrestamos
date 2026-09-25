<?php

/**
 * @var string $nombres
 * @var string $apellidos
 * @var string $rol
 * @var string $fecha
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio · Préstamos</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
    <script src="<?= base_url('assets/js/menu.js') ?>" defer></script>
</head>

<body class="min-h-screen bg-fondo text-texto antialiased">
    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        <?php $this->load->view('partials/sidebar.php'); ?>

        <div class="flex flex-1 flex-col">
            <!-- HEADER -->
            <?php $this->load->view('partials/topbar.php'); ?>
            <!-- MAIN -->
            <main class="flex-1 px-4 py-6 sm:px-6 sm:py-8 lg:px-10 lg:py-10">
                <div class="mx-auto max-w-5xl">
                    <section class="relative h-56 overflow-hidden rounded-2xl bg-titulo shadow-lg sm:h-64">
                        <img src="<?= base_url('assets/img/MuniLinares.jpg') ?>" alt="" class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-titulo via-titulo/80 to-titulo/50 sm:to-titulo/20"></div>
                        <div class="relative flex h-full flex-col justify-center px-6 text-white sm:px-10">
                            <p class="text-sm font-semibold uppercase tracking-widest text-borde"><?= html_escape($fecha) ?></p>
                            <h2 class="mt-2 text-3xl font-bold sm:text-4xl">Hola, <?= html_escape($nombres) ?></h2>
                            <p class="mt-3 max-w-md text-base text-borde sm:text-lg">Registra y sigue los préstamos de equipos informáticos.</p>
                        </div>
                    </section>

                    <div class="mt-6 flex flex-col items-start gap-6 rounded-2xl border border-borde bg-white p-6 shadow-xl shadow-titulo/10 sm:mt-8 sm:gap-8 sm:p-8 lg:flex-row lg:items-center lg:p-10">
                        <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-suave text-boton">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-titulo sm:text-2xl">Acta de Entrega</h3>
                            <p class="mt-2 text-base leading-relaxed sm:text-lg">Registra los equipos que se le entregan a un funcionario y genera el acta en PDF lista para firmar.</p>
                        </div>
                        <a href="<?= site_url('prestamos') ?>" class="w-full shrink-0 rounded-xl bg-boton px-8 py-4 text-center text-base font-semibold text-white transition-colors hover:bg-hover sm:text-lg lg:w-auto">Crear Acta de Entrega</a>
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>

</html>