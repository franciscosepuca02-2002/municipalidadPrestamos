-- =====================================================================
-- municipalidadPrestamos - Esquema de la base de datos
-- Sistema de actas de entrega y recepcion de equipos informaticos
--
-- MySQL / MariaDB - InnoDB - utf8mb4_general_ci
-- Ejecutar completo y en este orden: las claves foraneas exigen que la
-- tabla referenciada exista antes.
-- =====================================================================

CREATE DATABASE IF NOT EXISTS municipalidad_prestamos
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_general_ci;

USE municipalidad_prestamos;

SET NAMES utf8mb4;

-- Para volver a ejecutar el script desde cero, descomenta este bloque.
-- El orden es el inverso al de creacion.
--
-- DROP TABLE IF EXISTS logs;
-- DROP TABLE IF EXISTS recepcion_items;
-- DROP TABLE IF EXISTS recepciones;
-- DROP TABLE IF EXISTS prestamo_items;
-- DROP TABLE IF EXISTS prestamos;
-- DROP TABLE IF EXISTS items;
-- DROP TABLE IF EXISTS funcionarios;
-- DROP TABLE IF EXISTS usuarios;


-- ---------------------------------------------------------------------
-- 1. usuarios
--    Cuentas del sistema. Solo el administrador las gestiona.
-- ---------------------------------------------------------------------
CREATE TABLE usuarios (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombres     VARCHAR(100) NOT NULL,
    apellidos   VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL,
    password    VARCHAR(255) NOT NULL,                      -- hash de password_hash()
    rol         ENUM('administrador','encargado') NOT NULL,
    is_active   TINYINT(1) NOT NULL DEFAULT 1,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_usuarios_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ---------------------------------------------------------------------
-- 2. funcionarios
--    Quien recibe el equipo prestado. NO tiene acceso al sistema.
--    El rut es opcional: sirve para buscarlo, no se imprime en el acta.
-- ---------------------------------------------------------------------
CREATE TABLE funcionarios (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    rut                 VARCHAR(12) NULL,
    nombres             VARCHAR(100) NOT NULL,
    apellidos           VARCHAR(100) NOT NULL,
    cargo_departamento  VARCHAR(100) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_funcionarios_rut (rut)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ---------------------------------------------------------------------
-- 3. items
--    Equipos. Se crean al vuelo desde el formulario del acta.
--    Casi todo acepta NULL: no todos los equipos traen los mismos datos.
--    Los UNIQUE admiten varios NULL, por eso conviven los items con y
--    sin identificador. Los que no se pueden identificar se duplican.
-- ---------------------------------------------------------------------
CREATE TABLE items (
    id                 INT UNSIGNED NOT NULL AUTO_INCREMENT,
    numero_inventario  VARCHAR(30) NULL,
    marca              VARCHAR(255) NULL,
    modelo             VARCHAR(255) NULL,
    sn                 VARCHAR(20) NULL,
    mac_imei           VARCHAR(25) NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_items_numero_inventario (numero_inventario),
    UNIQUE KEY uq_items_sn (sn),
    UNIQUE KEY uq_items_mac_imei (mac_imei)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ---------------------------------------------------------------------
-- 4. prestamos
--    Cabecera del acta de ENTREGA.
--    archivo_generado  = el .docx sin firmar que genera el sistema
--    archivo_escaneado = el PDF firmado y escaneado (se puede reemplazar)
-- ---------------------------------------------------------------------
CREATE TABLE prestamos (
    id                 INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_funcionario     INT UNSIGNED NOT NULL,
    id_usuario         INT UNSIGNED NOT NULL,               -- quien registra el prestamo
    fecha              DATE NOT NULL,
    observacion        VARCHAR(255) NULL,
    estado             ENUM('abierto','parcial','cerrado','anulado') NOT NULL DEFAULT 'abierto',
    archivo_generado   VARCHAR(255) NULL,
    archivo_escaneado  VARCHAR(255) NULL,
    PRIMARY KEY (id),
    KEY idx_prestamos_funcionario (id_funcionario),
    KEY idx_prestamos_usuario (id_usuario),
    KEY idx_prestamos_estado (estado),
    CONSTRAINT fk_prestamos_funcionario
        FOREIGN KEY (id_funcionario) REFERENCES funcionarios (id),
    CONSTRAINT fk_prestamos_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ---------------------------------------------------------------------
-- 5. prestamo_items
--    Detalle del acta de entrega: una fila por item entregado.
--    La observacion lleva los accesorios y la condicion del equipo
--    ("sin cargador", "pantalla trizada"), tal como lo escriben hoy.
--    Un item pasa a 'hurtado' al subir el parte de Carabineros.
-- ---------------------------------------------------------------------
CREATE TABLE prestamo_items (
    id                INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_prestamo       INT UNSIGNED NOT NULL,
    id_item           INT UNSIGNED NOT NULL,
    observacion       VARCHAR(255) NULL,
    estado            ENUM('prestado','devuelto','hurtado') NOT NULL DEFAULT 'prestado',
    archivo_denuncia  VARCHAR(255) NULL,
    PRIMARY KEY (id),
    KEY idx_prestamo_items_prestamo (id_prestamo),
    KEY idx_prestamo_items_item (id_item),
    KEY idx_prestamo_items_estado (estado),
    CONSTRAINT fk_prestamo_items_prestamo
        FOREIGN KEY (id_prestamo) REFERENCES prestamos (id),
    CONSTRAINT fk_prestamo_items_item
        FOREIGN KEY (id_item) REFERENCES items (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ---------------------------------------------------------------------
-- 6. recepciones
--    Cabecera del acta de RECEPCION. Cuelga de un prestamo, por eso no
--    repite el funcionario: se hereda. Un acta puede traer varios items,
--    pero siempre del mismo prestamo.
-- ---------------------------------------------------------------------
CREATE TABLE recepciones (
    id                 INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_prestamo        INT UNSIGNED NOT NULL,
    id_usuario         INT UNSIGNED NOT NULL,               -- quien registra la recepcion
    fecha              DATE NOT NULL,
    observacion        VARCHAR(255) NULL,
    archivo_generado   VARCHAR(255) NULL,
    archivo_escaneado  VARCHAR(255) NULL,
    PRIMARY KEY (id),
    KEY idx_recepciones_prestamo (id_prestamo),
    KEY idx_recepciones_usuario (id_usuario),
    CONSTRAINT fk_recepciones_prestamo
        FOREIGN KEY (id_prestamo) REFERENCES prestamos (id),
    CONSTRAINT fk_recepciones_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ---------------------------------------------------------------------
-- 7. recepcion_items
--    Detalle del acta de recepcion: que items trae de vuelta.
--    El UNIQUE de id_prestamo_item impide devolver dos veces el mismo
--    item, sin escribir una sola linea de validacion.
-- ---------------------------------------------------------------------
CREATE TABLE recepcion_items (
    id                INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_recepcion      INT UNSIGNED NOT NULL,
    id_prestamo_item  INT UNSIGNED NOT NULL,
    observacion       VARCHAR(255) NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_recepcion_items_prestamo_item (id_prestamo_item),
    KEY idx_recepcion_items_recepcion (id_recepcion),
    CONSTRAINT fk_recepcion_items_recepcion
        FOREIGN KEY (id_recepcion) REFERENCES recepciones (id),
    CONSTRAINT fk_recepcion_items_prestamo_item
        FOREIGN KEY (id_prestamo_item) REFERENCES prestamo_items (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ---------------------------------------------------------------------
-- 8. logs
--    Registro de actividad: prestamo, devolucion, carga de documentos y
--    anulacion. Solo el administrador puede verlos.
-- ---------------------------------------------------------------------
CREATE TABLE logs (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_usuario  INT UNSIGNED NOT NULL,
    accion      VARCHAR(50) NOT NULL,
    detalle     VARCHAR(255) NOT NULL,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_logs_usuario (id_usuario),
    KEY idx_logs_created_at (created_at),
    CONSTRAINT fk_logs_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ---------------------------------------------------------------------
-- Usuario administrador inicial
--
-- Hace falta para poder entrar la primera vez y crear al resto.
-- La clave es "admin123": CAMBIALA apenas inicies sesion, y no subas
-- este usuario al servidor de la municipalidad tal cual.
--
-- Para generar otro hash:
--   php -r "echo password_hash('tu-clave', PASSWORD_DEFAULT);"
-- ---------------------------------------------------------------------
INSERT INTO usuarios (nombres, apellidos, email, password, rol, is_active) VALUES
('Admin', 'Sistema', 'admin@linares.cl',
 '$2y$12$rdiM4EF.Q0khHhy1jHkAaOcfnhr9eRznbwAr0huE3SnB2Fv4.hAla',
 'administrador', 1);
