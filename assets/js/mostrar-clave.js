document.querySelectorAll('[data-mostrar-clave]').forEach(function (boton) {
    boton.addEventListener('click', function () {
        const campo = document.getElementById(boton.dataset.mostrarClave);
        const oculta = campo.type === 'password';

        campo.type = oculta ? 'text' : 'password';

        boton.setAttribute('aria-label', oculta ? 'Ocultar contraseña' : 'Mostrar contraseña');
        boton.classList.toggle('text-boton', oculta);
        boton.classList.toggle('text-texto/60', ! oculta);
    });
});