--
-- Estructura de tabla para la tabla `comandas`
--
CREATE TABLE comandas (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_servicio INT NOT NULL,
    date_start DATETIME NOT NULL DEFAULT NOW(),
    date_end DATETIME DEFAULT NULL,
    FOREIGN KEY (id_servicio) REFERENCES servicios(id)
) AUTO_INCREMENT=1;

--
-- Estructura de tabla para la tabla `detalles`
--
CREATE TABLE detalles (
    id INT NOT NULL AUTO_INCREMENT,
    id_comanda CHAR(5) NOT NULL,
    id_bebida INT DEFAULT NULL,
    id_comida INT DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_comanda) REFERENCES comandas(id),
    FOREIGN KEY (id_bebida) REFERENCES bebidas(id),
    FOREIGN KEY (id_comida) REFERENCES comidas(id)
) AUTO_INCREMENT=1;