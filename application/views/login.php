<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión · Préstamos</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
</head>

<body class="min-h-screen bg-fondo text-texto antialiased">
    <div class="flex min-h-screen">

        <aside class="relative hidden w-1/2 flex-col justify-between overflow-hidden bg-titulo p-12 text-white lg:flex xl:p-16">
            <img src="<?= base_url('assets/img/MuniLinares.jpg') ?>" alt="" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-titulo via-titulo/70 to-titulo/40"></div>

            <p class="relative text-base font-semibold uppercase tracking-widest xl:text-lg">Municipalidad de Linares</p>

            <div class="relative">
                <h1 class="text-5xl font-bold leading-tight xl:text-6xl">Sistema de Seguimiento<br>de Préstamos</h1>
                <p class="mt-6 max-w-lg text-lg text-borde xl:text-xl">Actas de entrega y recepción de equipos informáticos.</p>
            </div>

            <p class="relative text-base text-borde">Departamento de Informática</p>
        </aside>

        <main class="flex w-full flex-col items-center justify-center p-6 lg:w-1/2">
            <div class="w-full max-w-md">
                <div class="text-center">
                    <img src="<?= base_url('assets/img/logo-linares3.png') ?>" alt="Municipalidad de Linares" class="mx-auto h-24 w-auto sm:h-28 xl:h-32">
                    <p class="mt-4 text-sm font-semibold uppercase tracking-widest text-texto lg:hidden">Sistema de Seguimiento de Préstamos</p>
                </div>

                <div class="mt-8 rounded-2xl border border-borde bg-white p-6 shadow-xl shadow-titulo/10 sm:p-10">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold text-titulo">Iniciar sesión</h2>
                    </div>

                    <form action="<?= site_url('login') ?>" method="post" class="mt-10 space-y-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-titulo">Correo electrónico</label>
                            <input type="email" id="email" name="email" placeholder="nombre@correo.cl" autocomplete="email" required
                                class="mt-2 w-full rounded-lg border border-borde bg-fondo focus:bg-white px-4 py-3 text-base text-titulo placeholder:text-texto/40 focus:border-boton focus:outline-none focus:ring-2 focus:ring-suave">
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium text-titulo">Contraseña</label>
                                <a href="#" class="text-sm text-boton hover:text-hover hover:underline">¿Olvidaste tu contraseña?</a>
                            </div>
                            <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password" required
                                class="mt-2 w-full rounded-lg border border-borde bg-fondo focus:bg-white px-4 py-3 text-base text-titulo placeholder:text-texto/40 focus:border-boton focus:outline-none focus:ring-2 focus:ring-suave">
                        </div>

                        <button type="submit" class="w-full rounded-lg bg-boton py-3 text-base font-semibold text-white transition-colors hover:bg-hover focus:outline-none focus:ring-2 focus:ring-borde">
                            Iniciar sesión
                        </button>
                    </form>
                </div>
            </div>

            <p class="mt-12 text-center text-sm text-texto/60">&copy; <?= date('Y') ?> Ilustre Municipalidad de Linares</p>
        </main>
    </div>
</body>

</html>
