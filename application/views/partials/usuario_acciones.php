<?php

/**
 * @var array $u
 */
?>
<?php if ($u['rol'] === 'administrador') : ?>

    <div class="flex items-center justify-end gap-1.5 text-texto/60" title="Los administradores no se pueden modificar desde esta lista">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
        </svg>
        <span class="text-xs font-medium">Protegido</span>
    </div>

<?php else : ?>

    <div class="flex items-center justify-end gap-2">
        <a href="<?= site_url('usuarios/editar/' . (int) $u['id']) ?>" title="Editar" class="rounded-lg p-2 text-boton transition-colors hover:bg-suave">
            <span class="sr-only">Editar usuario</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
            </svg>
        </a>

        <?= form_open('usuarios/cambiar_estado') ?>
        <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
        <input type="hidden" name="activo" value="<?= $u['is_active'] ? 0 : 1 ?>">

        <button type="submit" title="<?= $u['is_active'] ? 'Desactivar' : 'Activar' ?>" class="rounded-lg p-2 transition-colors <?= $u['is_active'] ? 'text-red-600 hover:bg-red-50' : 'text-green-600 hover:bg-green-50' ?>">
            <span class="sr-only"><?= $u['is_active'] ? 'Desactivar' : 'Activar' ?> usuario</span>
            <?php if ($u['is_active']) : ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            <?php else : ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            <?php endif; ?>
        </button>
        </form>
    </div>

<?php endif; ?>