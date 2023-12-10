CREATE TABLE `clientes` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    `comensales` INT NOT NULL,
    fecha_baja DATE DEFAULT NUll,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

INSERT INTO clientes (nombre, comensales) VALUES
('Cliente de 2', 2),
('Cliente de 2', 2),
('Cliente de 4', 4),
('Cliente de 4', 4),
('Cliente de 1', 1);