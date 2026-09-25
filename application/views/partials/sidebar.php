<?php

/**
 * @var string $nombres
 * @var string $apellidos
 * @var string $rol
 * @var string $activo
 */

?>

<div id="menu-fondo" class="fixed inset-0 z-30 hidden bg-titulo/50 md:hidden"></div>

<aside id="menu" class="fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 -translate-x-full flex-col overflow-y-auto bg-texto px-6 py-8 text-white transition-transform duration-200 md:static md:translate-x-0">
    <button type="button" id="menu-cerrar" aria-label="Cerrar menú" class="absolute right-3 top-3 rounded-lg p-2 text-white transition-colors hover:bg-white/10 md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
    <a href="<?= site_url('perfil') ?>" class="flex flex-col items-center rounded-xl px-2 py-4 text-center transition-colors <?= isset($activo) && $activo === 'perfil' ? 'bg-white/10' : 'hover:bg-white/10' ?>">
        <span class="flex h-20 w-20 items-center justify-center rounded-full bg-boton">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </span>
        <span class="mt-4 font-semibold"><?= html_escape($nombres . ' ' . $apellidos) ?></span>
        <span class="text-sm text-borde"><?= html_escape(ucfirst($rol)) ?></span>
        <span class="mt-2 text-xs font-semibold uppercase tracking-widest text-borde">Mi perfil</span>
    </a>

    <nav class="mt-10 flex flex-col gap-1">
        <?php
        $activo = isset($activo) ? $activo : '';

        $clase = function ($seccion) use ($activo) {
            return $seccion === $activo
                ? 'rounded-lg bg-white/10 px-4 py-3 font-medium text-white'
                : 'rounded-lg px-4 py-3 font-medium text-white transition-colors hover:bg-white/10';
        };
        ?>
        <a href="<?= site_url('inicio') ?>" class="<?= $clase('inicio') ?>">Inicio</a>
        <a href="<?= site_url('prestamos') ?>" class="<?= $clase('prestamos') ?>">Préstamos</a>
        <a href="#" class="rounded-lg px-4 py-3 font-medium text-white transition-colors hover:bg-white/10">Equipos</a>
        <?php if (es_admin()) : ?>
            <a href="<?= site_url('usuarios') ?>" class="<?= $clase('usuarios') ?>">Usuarios</a>
        <?php endif; ?>
        <a href="#" class="rounded-lg px-4 py-3 font-medium text-white transition-colors hover:bg-white/10">Logs</a>
        <a href="#" class="rounded-lg px-4 py-3 font-medium text-white transition-colors hover:bg-white/10">Funcionarios</a>
    </nav>

    <div class="mt-6 border-t border-white/10 pt-6">
        <a href="<?= site_url('login/salir') ?>" class="block rounded-lg px-4 py-3 font-medium text-white transition-colors hover:bg-white/10">Cerrar sesión</a>
    </div>
</aside>