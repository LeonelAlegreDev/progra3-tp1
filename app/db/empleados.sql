--
-- Estructura de tabla para la tabla `empleados`
--
CREATE TABLE `empleados` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `salario` float NOT NULL,
    `rol` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `fechaBaja` date DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `rol` (`rol`),
    CONSTRAINT `rol_valido` FOREIGN KEY (`rol`) REFERENCES `roles_empleados` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

--
-- Estructura de tabla para la tabla `roles_empleados`
--
CREATE TABLE `roles_empleados` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL UNIQUE,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles_empleados`
--
INSERT INTO `roles_empleados` (`nombre`) VALUES
('bartender'),
('cervecero'),
('cocinero'),
('mozo');


