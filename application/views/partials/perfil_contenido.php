<?php

/**
 * @var array       $perfil
 * @var string|null $exito
 */

$etiqueta = 'inline-flex rounded-full px-3 py-1 text-xs font-semibold';
$tarjeta  = 'rounded-2xl border border-borde bg-white p-6 shadow-xl shadow-titulo/10 sm:p-8';
$dato     = 'text-xs font-bold uppercase tracking-wide text-texto/60';
$input    = 'w-full rounded-lg border border-borde bg-fondo px-4 py-3 pr-12 text-base text-titulo focus:border-boton focus:bg-white focus:outline-none focus:ring-2 focus:ring-suave';
$ojo      = 'absolute inset-y-0 right-0 flex w-12 items-center justify-center rounded-r-lg text-texto/60 transition-colors hover:text-boton';
?>
<div class="mx-auto max-w-5xl">

    <div>
        <h2 class="text-2xl font-bold text-titulo sm:text-3xl">Mi perfil</h2>
        <p class="mt-1">Consulta tus datos y actualiza tu contraseña.</p>
    </div>

    <?php if ($exito) : ?>
        <div role="status" class="mt-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"><?= html_escape($exito) ?></div>
    <?php endif; ?>

    <!-- Tarjeta de identidad -->
    <div class="mt-6 flex flex-col items-center gap-5 text-center sm:flex-row sm:text-left <?= $tarjeta ?>">
        <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-suave text-boton">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </div>
        <div class="min-w-0">
            <p class="text-xl font-bold text-titulo sm:text-2xl"><?= html_escape($perfil['nombres'] . ' ' . $perfil['apellidos']) ?></p>
            <p class="break-all"><?= html_escape($perfil['email']) ?></p>
            <div class="mt-3 flex flex-wrap justify-center gap-2 sm:justify-start">
                <span class="<?= $etiqueta ?> <?= $perfil['rol'] === 'administrador' ? 'bg-boton text-white' : 'bg-suave text-titulo' ?>"><?= html_escape(ucfirst($perfil['rol'])) ?></span>
                <span class="inline-flex items-center text-xs text-texto/60">Desde <?= date('d/m/Y', strtotime($perfil['created_at'])) ?></span>
            </div>
        </div>
    </div>

    <div class="mt-6 grid items-start gap-6 lg:grid-cols-2">

        <!-- Datos personales (solo lectura) -->
        <section class="<?= $tarjeta ?>">
            <div class="flex items-center gap-3 border-b border-borde pb-4">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-suave text-boton">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                    </svg>
                </span>
                <h3 class="text-lg font-bold text-titulo">Datos personales</h3>
            </div>

            <dl class="mt-6 space-y-5">
                <div>
                    <dt class="<?= $dato ?>">Nombres</dt>
                    <dd class="mt-1 text-base text-titulo"><?= html_escape($perfil['nombres']) ?></dd>
                </div>
                <div>
                    <dt class="<?= $dato ?>">Apellidos</dt>
                    <dd class="mt-1 text-base text-titulo"><?= html_escape($perfil['apellidos']) ?></dd>
                </div>
                <div>
                    <dt class="<?= $dato ?>">Correo electrónico</dt>
                    <dd class="mt-1 break-all text-base text-titulo"><?= html_escape($perfil['email']) ?></dd>
                </div>
                <div>
                    <dt class="<?= $dato ?>">Rol</dt>
                    <dd class="mt-1 text-base text-titulo"><?= html_escape(ucfirst($perfil['rol'])) ?></dd>
                </div>
            </dl>

            <p class="mt-6 rounded-lg bg-fondo px-4 py-3 text-sm text-texto/80">
                Si tus datos no son correctos, pídele al administrador del sistema que los corrija.
            </p>
        </section>

        <!-- Cambiar contraseña -->
        <section class="<?= $tarjeta ?>">
            <div class="flex items-center gap-3 border-b border-borde pb-4">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-suave text-boton">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </span>
                <h3 class="text-lg font-bold text-titulo">Cambiar contraseña</h3>
            </div>

            <?= form_open('perfil/cambiar_password', array('class' => 'mt-6 space-y-5')) ?>
            <div>
                <label for="password_actual" class="block text-sm font-medium text-titulo">Contraseña actual</label>
                <div class="relative mt-2">
                    <input type="password" id="password_actual" name="password_actual" autocomplete="current-password" required class="<?= $input ?>">
                    <button type="button" data-mostrar-clave="password_actual" aria-label="Mostrar contraseña" class="<?= $ojo ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>
                <?= form_error('password_actual') ?>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-titulo">Nueva contraseña</label>
                <div class="relative mt-2">
                    <input type="password" id="password" name="password" autocomplete="new-password" required class="<?= $input ?>">
                    <button type="button" data-mostrar-clave="password" aria-label="Mostrar contraseña" class="<?= $ojo ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>
                <?= form_error('password') ?>
                <p class="mt-1.5 text-sm text-texto/60">Mínimo 8 caracteres.</p>
            </div>

            <button type="submit" class="w-full rounded-xl bg-boton py-3 font-semibold text-white transition-colors hover:bg-hover">Actualizar contraseña</button>
            </form>
        </section>

    </div>
</div>