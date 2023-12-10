--
-- Estructura de tabla para la tabla `mesas`
--
CREATE TABLE mesas (
    id INT NOT NULL UNIQUE AUTO_INCREMENT,
    estado VARCHAR(100) NOT NULL DEFAULT "disponible",
    capacidad INT NOT NULL,
    PRIMARY KEY (id),
    KEY estado (estado),
    CONSTRAINT estado_valido FOREIGN KEY (estado) REFERENCES `estados_mesas` (`nombre`)
) AUTO_INCREMENT=1;

CREATE TABLE `estados_mesas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL UNIQUE DEFAULT 'fuera de servicio',
    PRIMARY KEY (`id`)
) AUTO_INCREMENT=1;

--
-- Volcado de datos para 'estados_mesas'
--
INSERT INTO estados_mesas (nombre) VALUES
('fuera de servicio'),
('disponible'),
('ocupada'),
('cerrada');

--
-- Volcado de datos para 'mesas'
--
INSERT INTO mesas (estado, capacidad) VALUES
('disponible', 2),
('disponible', 2),
('disponible', 4),
('disponible', 4);