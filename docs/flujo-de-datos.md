# Flujo de datos del sistema

Qué se escribe en cada tabla y en cada carpeta, paso a paso, siguiendo el orden en que ocurren las cosas.

**El escenario:** María (encargada, `usuarios.id = 2`) le entrega a Juan Pérez, de Tránsito, un notebook, un monitor y un pendrive sin inventario.

---

## Paso 1 · María llena el formulario de préstamo

Busca al funcionario por RUT. No existe → lo crea desde el mismo formulario:

**`funcionarios`** → 1 fila nueva

```
id=4 · rut='12345678-9' · nombres='Juan' · apellidos='Pérez' · cargo_departamento='Tránsito'
```

Después agrega los tres equipos. Los busca por N° de inventario / SN / MAC / IMEI; los que no existen se crean:

**`items`** → 3 filas nuevas

```
id=11 · numero_inventario='INV-1042' · marca='HP'  · modelo='ProBook 450'   · sn='5CD1234' · mac_imei='A4:BB:6D:...'
id=12 · numero_inventario='INV-0887' · marca='LG'  · modelo='24MK430'       · sn=NULL      · mac_imei=NULL
id=13 · numero_inventario=NULL       · marca=NULL  · modelo='Pendrive 16GB' · sn=NULL      · mac_imei=NULL
```

El pendrive no tiene ningún identificador: si mañana prestan otro igual, se crea una fila nueva. Está aceptado que se dupliquen.

**Importante:** `items` guarda **el equipo**, no el préstamo. Una vez creada la fila, no se vuelve a tocar nunca. No tiene estado, no sabe si está prestado.

## Paso 2 · Guarda el formulario

Esto es **una sola transacción**: o se escribe todo, o no se escribe nada.

**`prestamos`** → 1 fila (la cabecera del acta)

```
id=7 · id_funcionario=4 · id_usuario=2 · fecha='2026-09-25'
observacion=NULL · estado='abierto'
archivo_generado=NULL · archivo_escaneado=NULL
```

**`prestamo_items`** → 3 filas (el detalle del acta)

```
id=21 · id_prestamo=7 · id_item=11 · observacion='Con cargador y mochila' · estado='prestado'
id=22 · id_prestamo=7 · id_item=12 · observacion='Sin cable HDMI'          · estado='prestado'
id=23 · id_prestamo=7 · id_item=13 · observacion=NULL                      · estado='prestado'
```

Fíjate en la diferencia: **la observación del acta vive aquí, no en `items`**. "Con cargador" es verdad de *esta entrega*, no del notebook para siempre.

**`logs`** → 1 fila

```
id_usuario=2 · accion='prestamo' · detalle='Prestamo #7 a Juan Pérez, 3 items'
```

## Paso 3 · El sistema genera el Word

Lee el préstamo con sus items (un `JOIN` de `prestamos` + `funcionarios` + `prestamo_items` + `items`), rellena la plantilla y guarda el archivo:

**Archivo** → `uploads/generados/entrega_7.docx`

**`prestamos`** → se actualiza la fila 7

```
archivo_generado = 'entrega_7.docx'
```

En la columna se guarda **solo el nombre del archivo**, no la ruta completa. La carpeta va en un archivo de configuración: si mañana cambia, se cambia un valor y no 500 filas.

Ese Word sin firmar es el original de referencia: sirve para reimprimir y para comparar si al firmarlo alguien le agregó algo a mano.

## Paso 4 · Imprimen, firman, escanean y suben el PDF

**Archivo** → `uploads/escaneados/entrega_7.pdf`

**`prestamos`** → fila 7

```
archivo_escaneado = 'entrega_7.pdf'
```

**`logs`** → `accion='carga_documento'`

Si el escaneo sale torcido, suben otro: se sobrescribe la columna (y el archivo). No queda historial, y así lo pidieron.

En este punto el préstamo está **completo y vigente**: `estado='abierto'`, tres items en `'prestado'`.

---

## Paso 5 · Dos meses después Juan devuelve el notebook y el monitor

María abre el préstamo 7, marca los items 21 y 22 y registra la recepción. Otra transacción:

**`recepciones`** → 1 fila (cabecera del acta de recepción)

```
id=3 · id_prestamo=7 · id_usuario=2 · fecha='2026-11-20' · observacion=NULL
```

**`recepcion_items`** → 2 filas (qué trae de vuelta esa acta)

```
id=8 · id_recepcion=3 · id_prestamo_item=21 · observacion=NULL
id=9 · id_recepcion=3 · id_prestamo_item=22 · observacion='Llega con la pantalla trizada'
```

**`prestamo_items`** → se actualizan las filas 21 y 22

```
estado = 'devuelto'
```

**`prestamos`** → fila 7

```
estado = 'parcial'     ← quedan items sin devolver
```

Después se genera el Word (`uploads/generados/recepcion_3.docx` → `recepciones.archivo_generado`), se imprime, se firma, se escanea y se sube (`uploads/escaneados/recepcion_3.pdf` → `recepciones.archivo_escaneado`). El mismo circuito del préstamo, pero en la otra tabla.

**`logs`** → `accion='devolucion'`

La recepción **no toca `items`**: el notebook sigue siendo el mismo equipo. Lo que cambió de estado es la *línea del acta*, no el equipo.

## Paso 6 · El pendrive fue hurtado

No hay acta de recepción, porque no hay nada que recibir. Suben el parte de Carabineros y marcan el item:

**Archivo** → `uploads/denuncias/denuncia_7_20261212.pdf`

**`prestamo_items`** → fila 23

```
estado = 'hurtado'
archivo_denuncia = 'denuncia_7_20261212.pdf'
```

**`prestamos`** → fila 7

```
estado = 'cerrado'     ← ya no queda ningún item en 'prestado'
```

**`logs`** → `accion='carga_documento'`

Si el mismo parte cubriera items de otro préstamo, se sube de nuevo en ese otro préstamo. El archivo se duplica en disco y está aceptado.

---

## Las dos máquinas de estado

Todo el seguimiento se sostiene en estos dos campos.

**`prestamo_items.estado`** — el estado de *una línea del acta*:

```
prestado ──► devuelto   (al registrar una recepción)
         └─► hurtado    (al subir el parte de Carabineros)
```

**`prestamos.estado`** — se recalcula después de cada devolución o hurto, mirando sus items:

```
abierto  → todos sus items siguen en 'prestado'
parcial  → algunos devueltos/hurtados, y al menos uno en 'prestado'
cerrado  → ninguno en 'prestado'
anulado  → lo anuló el administrador (solo si no tenía devoluciones)
```

Esa regla la calcula el modelo en la misma operación en que cambia un item. Es el punto donde más fácil se descuadran los datos, así que conviene que viva en **un solo método**, algo como `Prestamo_model->recalcular_estado($id_prestamo)`, y que nadie más escriba esa columna.

## Función de cada tabla, en una línea

| Tabla | Qué es | Cuándo se escribe |
|---|---|---|
| `usuarios` | quién usa el sistema | solo cuando el admin crea o edita una cuenta |
| `funcionarios` | a quién se le presta | al crear uno nuevo desde el formulario |
| `items` | el equipo físico | al registrarlo por primera vez. **Nunca más se toca** |
| `prestamos` | **el acta de entrega** | al registrar el préstamo, al guardar cada archivo y al recalcular el estado |
| `prestamo_items` | **una línea del acta** y el seguimiento de ese equipo | al crear el acta, al devolverlo y al marcarlo hurtado |
| `recepciones` | **el acta de recepción** | al registrar una devolución y al guardar sus archivos |
| `recepcion_items` | qué items trae esa acta de vuelta | solo al registrar la devolución |
| `logs` | quién hizo qué y cuándo | en cada préstamo, devolución, carga y anulación |

Y las carpetas:

```
uploads/generados/     ← los .docx que arma el sistema   (prestamos + recepciones)
uploads/escaneados/    ← los PDF firmados                (prestamos + recepciones)
uploads/denuncias/     ← los partes de Carabineros       (prestamo_items)
```

## La consulta que va a usar el sistema todo el día

"¿Qué está prestado hoy y a quién?" sale de una sola consulta, y por eso el modelo está armado así:

```
prestamo_items (estado = 'prestado')
  → prestamos      (de qué acta viene, y el estado del acta)
  → funcionarios   (quién lo tiene)
  → items          (qué equipo es)
```

Filtrando por `funcionarios.id` se obtiene "todo lo que tiene Juan". Filtrando por `items.numero_inventario`, "dónde está el INV-1042". No hace falta ninguna columna de disponibilidad en `items`, que es justamente lo que se decidió no llevar.

## El caso aparte: anular

Solo el administrador, y solo si el préstamo **no tiene ninguna fila en `recepcion_items`**. Se cambia `prestamos.estado='anulado'` y se escribe el log. No se borra nada: ni el acta, ni los items, ni los archivos. Si ya hubo devoluciones, no se anula — se registra una recepción normal por lo que quede.
