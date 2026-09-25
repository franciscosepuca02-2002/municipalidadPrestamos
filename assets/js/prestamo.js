// ---------------------------------------------------------------------
// Formulario de acta de entrega: busca funcionario, busca equipos,
// arma la tabla de items y valida antes de enviar.
// ---------------------------------------------------------------------

const formulario = document.getElementById("form-prestamo");

const campoRut = document.getElementById("rut");
const botonBuscarFuncionario = document.getElementById("buscar-funcionario");
const idFuncionario = document.getElementById("id_funcionario");
const campoNombres = document.getElementById("nombres");
const campoApellidos = document.getElementById("apellidos");
const campoCargo = document.getElementById("cargo_departamento");
const avisoFuncionario = document.getElementById("aviso-funcionario");

const campoBuscarItem = document.getElementById("buscar-item");
const botonAgregarItem = document.getElementById("agregar-item");
const botonAgregarManual = document.getElementById("agregar-manual");
const avisoItem = document.getElementById("aviso-item");

const cuerpoTabla = document.getElementById("tabla-items");
const filaVacia = document.getElementById("fila-vacia");
const plantillaItem = document.getElementById("plantilla-item");
const plantillaItemNuevo = document.getElementById("plantilla-item-nuevo");

const urlFuncionario = formulario.dataset.urlFuncionario;
const urlItem = formulario.dataset.urlItem;

// Numera los campos items[0][...], items[1][...]. No se reutiliza al
// borrar una fila: que queden huecos no importa, PHP los recibe igual.
let indice = 0;

// ---------------------------------------------------------------------
// Utilidades
// ---------------------------------------------------------------------

// Lanza el error hacia arriba a propósito: un fallo de red NO es lo mismo
// que "no se encontró", y confundirlos abriría una fila manual por error.
async function pedir(url) {
	const respuesta = await fetch(url, {
		headers: { "X-Requested-With": "XMLHttpRequest" },
	});

	if (!respuesta.ok) {
		throw new Error("El servidor respondió " + respuesta.status);
	}

	return respuesta.json();
}

function mostrarAviso(elemento, texto, tipo) {
	const colores = {
		ok: "text-green-700",
		error: "text-red-600",
		info: "text-texto/60",
	};

	elemento.textContent = texto;
	elemento.className = "mt-2 text-sm " + colores[tipo];
}

// ---------------------------------------------------------------------
// Funcionario
// ---------------------------------------------------------------------

function bloquearDatosFuncionario(bloquear) {
	[campoNombres, campoApellidos, campoCargo].forEach(function (campo) {
		campo.readOnly = bloquear;
		campo.classList.toggle("bg-suave", bloquear);
	});
}

async function buscarFuncionario() {
	const rut = campoRut.value.trim();

	if (rut === "") {
		campoRut.focus();
		return;
	}

	let datos;

	try {
		datos = await pedir(urlFuncionario + "?rut=" + encodeURIComponent(rut));
	} catch (error) {
		mostrarAviso(
			avisoFuncionario,
			"No se pudo consultar al servidor.",
			"error",
		);
		return;
	}

	if (datos) {
		idFuncionario.value = datos.id;
		campoNombres.value = datos.nombres;
		campoApellidos.value = datos.apellidos;
		campoCargo.value = datos.cargo_departamento;
		bloquearDatosFuncionario(true);
		mostrarAviso(avisoFuncionario, "Funcionario encontrado.", "ok");
	} else {
		idFuncionario.value = "";
		campoNombres.value = "";
		campoApellidos.value = "";
		campoCargo.value = "";
		bloquearDatosFuncionario(false);
		campoNombres.focus();
		mostrarAviso(
			avisoFuncionario,
			"No está registrado. Completa los datos y se creará al guardar el acta.",
			"info",
		);
	}
}

// Si editan el RUT después de haber encontrado a alguien, el id deja de
// ser válido: se limpia para que el servidor no asocie a otra persona.
function olvidarFuncionario() {
	if (idFuncionario.value !== "") {
		idFuncionario.value = "";
		bloquearDatosFuncionario(false);
		avisoFuncionario.className = "hidden";
	}
}

// ---------------------------------------------------------------------
// Items
// ---------------------------------------------------------------------

function hayItems() {
	return cuerpoTabla.querySelectorAll("tr:not(#fila-vacia)").length > 0;
}

function actualizarFilaVacia() {
	filaVacia.classList.toggle("hidden", hayItems());
}

function yaEstaEnLaTabla(id) {
	const puestos = cuerpoTabla.querySelectorAll('input[name$="[id_item]"]');

	return Array.from(puestos).some(function (campo) {
		return campo.value === String(id);
	});
}

function crearFila(plantilla) {
	const fila = plantilla.content.cloneNode(true).querySelector("tr");

	fila.querySelectorAll("[name]").forEach(function (campo) {
		campo.name = campo.name.replace("__i__", indice);
	});

	indice = indice + 1;

	cuerpoTabla.insertBefore(fila, filaVacia);
	actualizarFilaVacia();

	return fila;
}

function agregarFilaExistente(datos) {
	const fila = crearFila(plantillaItem);

	fila.querySelector('input[data-campo="id_item"]').value = datos.id;

	fila.querySelectorAll("span[data-campo]").forEach(function (elemento) {
		elemento.textContent = datos[elemento.dataset.campo] || "—";
	});

	return fila;
}

function agregarFilaManual(texto) {
	const fila = crearFila(plantillaItemNuevo);

	if (texto) {
		fila.querySelector('input[name$="[numero_inventario]"]').value = texto;
	}

	fila.querySelector('input[type="text"]').focus();

	return fila;
}

async function buscarItem() {
	const texto = campoBuscarItem.value.trim();

	if (texto === "") {
		mostrarAviso(
			avisoItem,
			"Escribe un N° de inventario, serie, MAC o IMEI.",
			"error",
		);
		campoBuscarItem.focus();
		return;
	}

	let datos;

	try {
		datos = await pedir(urlItem + "?q=" + encodeURIComponent(texto));
	} catch (error) {
		mostrarAviso(avisoItem, "No se pudo consultar al servidor.", "error");
		return;
	}

	if (datos && yaEstaEnLaTabla(datos.id)) {
		mostrarAviso(avisoItem, "Ese equipo ya está en el acta.", "error");
		return;
	}

	if (datos) {
		agregarFilaExistente(datos);
		mostrarAviso(avisoItem, "Equipo agregado.", "ok");
	} else {
		agregarFilaManual(texto);
		mostrarAviso(
			avisoItem,
			"No está registrado: revisa los datos de la fila y se creará al guardar.",
			"info",
		);
	}

	campoBuscarItem.value = "";
}

// ---------------------------------------------------------------------
// Validación antes de enviar
// ---------------------------------------------------------------------

function filaManualVacia(fila) {
	const campos = fila.querySelectorAll('input[type="text"]');

	return Array.from(campos).every(function (campo) {
		return campo.name.endsWith("[observacion]") || campo.value.trim() === "";
	});
}

function validar(evento) {
	if (!hayItems()) {
		evento.preventDefault();
		mostrarAviso(avisoItem, "Agrega al menos un equipo al acta.", "error");
		return;
	}

	const filas = cuerpoTabla.querySelectorAll('tr[data-nuevo="1"]');

	for (const fila of filas) {
		if (filaManualVacia(fila)) {
			evento.preventDefault();
			mostrarAviso(
				avisoItem,
				"Hay un equipo nuevo sin datos: complétalo o quítalo.",
				"error",
			);
			fila.querySelector('input[type="text"]').focus();
			return;
		}
	}
}

// ---------------------------------------------------------------------
// Eventos
// ---------------------------------------------------------------------

botonBuscarFuncionario.addEventListener("click", buscarFuncionario);
campoRut.addEventListener("input", olvidarFuncionario);

botonAgregarItem.addEventListener("click", buscarItem);
botonAgregarManual.addEventListener("click", function () {
	agregarFilaManual("");
	mostrarAviso(
		avisoItem,
		"Completa los datos del equipo. Se creará al guardar el acta.",
		"info",
	);
});

// Enter dentro de los buscadores: buscar, no enviar el formulario.
campoRut.addEventListener("keydown", function (evento) {
	if (evento.key === "Enter") {
		evento.preventDefault();
		buscarFuncionario();
	}
});

campoBuscarItem.addEventListener("keydown", function (evento) {
	if (evento.key === "Enter") {
		evento.preventDefault();
		buscarItem();
	}
});

// Las filas no existen al cargar la página: delegación sobre el tbody.
cuerpoTabla.addEventListener("click", function (evento) {
	if (evento.target.closest(".quitar-item")) {
		evento.target.closest("tr").remove();
		actualizarFilaVacia();
	}
});

formulario.addEventListener("submit", validar);

actualizarFilaVacia();
