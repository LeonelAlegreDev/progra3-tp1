--
-- Estructura de tabla para la tabla `bebidas`
--
CREATE TABLE `bebidas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `marca` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
    `precio` float NOT NULL,
    `litros` float NOT NULL,
    `fechaBaja` date DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

INSERT INTO `bebidas` (`nombre`, `marca`, `descripcion`, `precio`, `litros`)
VALUES
    ('Coca-Cola', 'Coca-Cola', 'Refresco de cola con gas', 550, 2.25),
    ('Sprite', 'Coca-Cola', 'Refresco de limón con gas', 550, 2.25),
    ('Fanta Naranja', 'Coca-Cola', 'Refresco de naranja con gas', 550, 2.25),
    ('Quilmes Clásica', 'Quilmes', 'Cerveza rubia de malta con 5,0% de alcohol', 800, 1),
    ('Stella Artois', 'Anheuser-Busch InBev', 'Cerveza rubia de malta con 5,5% de alcohol', 950, 1),
    ('IPA Patagonia', 'Cervecería Patagonia', 'Cerveza rubia de malta con 6,5% de alcohol', 950, 0.730);

--
-- Estructura de tabla para la tabla `comidas`
--
CREATE TABLE `comidas` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `descripcion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
    `precio` float NOT NULL,
    `fechaBaja` date DEFAULT NULL,
    comensales INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

INSERT INTO `comidas` (`nombre`, `descripcion`, `precio`, `comensales`)
VALUES
    ('Milanesa Napolitana', 'Milanesa de carne cubierta con salsa de tomate, queso mozzarella y jamón.', 4550.00, 2),
    ('Hamburguesa de Panceta', 'Hamburguesa de carne de res con panceta ahumada, queso cheddar, cebolla caramelizada, lechuga y tomate.', 3300.00, 1),
    ('Zorrentinos de Jamón y Queso', 'Zorrentinos rellenos de jamón y queso, con salsa blanca y parmesano.', 3100.00, 1),
    ('Ensalada César', 'Ensalada de lechuga romana, pollo, parmesano, huevo duro y salsa César.', 2900.00, 1);
