const menu = document.getElementById('menu');
const fondo = document.getElementById('menu-fondo');
const botonAbrir = document.getElementById('menu-abrir');
const botonCerrar = document.getElementById('menu-cerrar');

function abrirMenu() {
    menu.classList.remove('-translate-x-full');
    fondo.classList.remove('hidden');
    botonAbrir.setAttribute('aria-expanded', 'true');
}

function cerrarMenu() {
    menu.classList.add('-translate-x-full');
    fondo.classList.add('hidden');
    botonAbrir.setAttribute('aria-expanded', 'false');
}

botonAbrir.addEventListener('click', abrirMenu);
botonCerrar.addEventListener('click', cerrarMenu);
fondo.addEventListener('click', cerrarMenu);

document.addEventListener('keydown', function (evento) {
    if (evento.key === 'Escape') {
        cerrarMenu();
    }
});