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
        <div id="menu-fondo" class="fixed inset-0 z-30 hidden bg-titulo/50 md:hidden"></div>

        <aside id="menu" class="fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 -translate-x-full flex-col overflow-y-auto bg-texto px-6 py-8 text-white transition-transform duration-200 md:static md:translate-x-0">
            <button type="button" id="menu-cerrar" aria-label="Cerrar menú" class="absolute right-3 top-3 rounded-lg p-2 text-white transition-colors hover:bg-white/10 md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="flex flex-col items-center text-center">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-boton">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <p class="mt-4 font-semibold">Nombre Apellido</p>
                <p class="text-sm text-borde">Administrador</p>
            </div>

            <nav class="mt-10 flex flex-col gap-1">
                <a href="<?= site_url('inicio') ?>" class="rounded-lg bg-white/10 px-4 py-3 font-medium text-white">Inicio</a>
                <a href="#" class="rounded-lg px-4 py-3 font-medium text-white transition-colors hover:bg-white/10">Préstamos</a>
                <a href="#" class="rounded-lg px-4 py-3 font-medium text-white transition-colors hover:bg-white/10">Equipos</a>
                <a href="#" class="rounded-lg px-4 py-3 font-medium text-white transition-colors hover:bg-white/10">Usuarios</a>
                <a href="#" class="rounded-lg px-4 py-3 font-medium text-white transition-colors hover:bg-white/10">Logs</a>
                <a href="#" class="rounded-lg px-4 py-3 font-medium text-white transition-colors hover:bg-white/10">Funcionarios</a>
            </nav>

            <div class="mt-6 border-t border-white/10 pt-6">
                <a href="<?= site_url('login') ?>" class="block rounded-lg px-4 py-3 font-medium text-white transition-colors hover:bg-white/10">Cerrar sesión</a>
            </div>
        </aside>

        <div class="flex flex-1 flex-col">
            <header class="relative flex h-16 items-center gap-3 bg-white px-4 shadow-sm sm:h-20 sm:px-6 lg:h-28 lg:justify-center lg:px-10">
                <button type="button" id="menu-abrir" aria-label="Abrir menú" aria-controls="menu" aria-expanded="false" class="-ml-2 shrink-0 rounded-lg p-2 text-titulo transition-colors hover:bg-suave md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <img src="<?= base_url('assets/img/logo-linares3.png') ?>" alt="" class="h-10 w-auto sm:h-14 lg:absolute lg:left-10 lg:h-16 xl:h-20">
                <h1 class="text-base font-bold leading-tight text-titulo sm:text-2xl lg:text-3xl">Municipalidad de Linares</h1>
            </header>

            <main class="flex-1 px-4 py-6 sm:px-6 sm:py-8 lg:px-10 lg:py-10">
                <div class="mx-auto max-w-5xl">

                    <section class="relative h-56 overflow-hidden rounded-2xl bg-titulo shadow-lg sm:h-64">
                        <img src="<?= base_url('assets/img/MuniLinares.jpg') ?>" alt="" class="absolute inset-0 h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-titulo via-titulo/80 to-titulo/50 sm:to-titulo/20"></div>
                        <div class="relative flex h-full flex-col justify-center px-6 text-white sm:px-10">
                            <p class="text-sm font-semibold uppercase tracking-widest text-borde">Jueves 24 de septiembre</p>
                            <h2 class="mt-2 text-3xl font-bold sm:text-4xl">Hola, Alejandro</h2>
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
                        <a href="#" class="w-full shrink-0 rounded-xl bg-boton px-8 py-4 text-center text-base font-semibold text-white transition-colors hover:bg-hover sm:text-lg lg:w-auto">Crear Acta de Entrega</a>
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>

</html>