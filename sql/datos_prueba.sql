-- =====================================================================
-- municipalidadPrestamos - Datos de prueba
--
-- Funcionarios e items para probar el formulario de prestamo.
-- NO subir esto al servidor de la municipalidad: el sistema parte de cero.
--
-- Ejecutar despues de esquema.sql.
-- =====================================================================

USE municipalidad_prestamos;

SET NAMES utf8mb4;

-- Para volver a cargarlos desde cero, descomenta estas dos lineas.
-- Solo funciona si ningun prestamo los esta usando todavia.
--
-- DELETE FROM items;
-- DELETE FROM funcionarios;


-- ---------------------------------------------------------------------
-- Funcionarios
-- Los RUT van normalizados: sin puntos, con guion y la K en mayuscula,
-- que es como los deja normalizar_rut() antes de guardarlos.
-- Los dos ultimos van sin RUT, para probar el caso de que no lo tengan
-- a mano al momento de hacer el acta.
-- ---------------------------------------------------------------------
INSERT INTO funcionarios (rut, nombres, apellidos, cargo_departamento) VALUES
('15840231-K', 'Alejandro',  'Silva San Martin',  'Analista de Ciberseguridad'),
('12345678-9', 'Juan Pablo', 'Perez Gonzalez',    'Inspector de Transito'),
('9876543-2',  'Maria Jose', 'Contreras Rojas',   'Encargada de Seguridad Publica'),
('17654321-4', 'Rodrigo',    'Serrano Quintana',  'Seguridad Publica'),
('20123456-7', 'Camila',     'Munoz Vergara',     'Secretaria de DIDECO'),
('8765432-1',  'Patricio',   'Valenzuela Diaz',   'Jefe de Transito'),
(NULL,         'Ignacio',    'Fuentes Araya',     'Practicante de Informatica'),
(NULL,         'Valentina',  'Reyes Soto',        'Administrativa de Finanzas');


-- ---------------------------------------------------------------------
-- Items
--
-- Fijate en la variedad, que es justo lo que tiene que aguantar el
-- formulario:
--   - notebooks y monitores con inventario, SN y MAC
--   - celulares con IMEI pero sin SN
--   - equipos sin numero de inventario
--   - dos pendrives identicos y sin ningun identificador (filas 14 y 15):
--     conviven porque los campos van en NULL, no en cadena vacia
-- ---------------------------------------------------------------------
INSERT INTO items (numero_inventario, marca, modelo, sn, mac_imei) VALUES
-- Notebooks
('INV-2026-041', 'Lenovo',   'ThinkPad T14s G4',   'PF4892LK-91', '00:1A:2B:3C:4D:5E'),
('INV-2026-042', 'Lenovo',   'ThinkPad T14s G4',   'PF4892LK-92', '00:1A:2B:3C:4D:6F'),
('INV-2026-055', 'HP',       'ProBook 450 G10',    '5CD1234ABC',  'A4:BB:6D:11:22:33'),
-- Monitores
('INV-2026-104', 'Dell',     'UltraSharp U2723QE', 'CN-0D5432-849X', NULL),
('INV-2026-105', 'LG',       '24MK430H',           '210NTKD5A123',   NULL),
-- Celulares
('INV-2026-088', 'Samsung',  'Galaxy S23 FE',      NULL, '358901234567890'),
('INV-2026-089', 'Samsung',  'Galaxy S20 FE',      NULL, '355468801245457'),
('INV-2026-090', 'Motorola', 'Moto G84',           NULL, '351120225833731'),
-- Routers portatiles (de los que aparecen en las actas reales)
('INV-2026-120', 'TCL',      'LINKZONE MW45A',     NULL, '357414800072235'),
('INV-2026-121', 'TCL',      'LINKZONE MW45A',     NULL, '357414800068100'),
-- Impresora y proyector
('INV-2026-200', 'Epson',    'EcoTank L3250',      'X5VB123456', NULL),
('INV-2026-201', 'Epson',    'PowerLite E20',      'XA2K987654', NULL),
-- Sin numero de inventario, pero identificables por su serie
(NULL, 'Kingston', 'DataTraveler 64GB', 'KDT64-00871', NULL),
-- Sin ningun identificador: se duplican a proposito
(NULL, 'Generico', 'Pendrive 16GB',  NULL, NULL),
(NULL, 'Generico', 'Pendrive 16GB',  NULL, NULL),
(NULL, 'Entel',    'Chip SIM',       NULL, NULL),
(NULL, NULL,       'Cable HDMI 2m',  NULL, NULL);
