CREATE TABLE servicios (
    id INT NOT NULL UNIQUE AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    id_mesa INT NOT NULL,
    date_start DATETIME NOT NULL DEFAULT NOW(),
    date_end DATETIME DEFAULT NULL,
    FOREIGN KEY (id_mesa) REFERENCES mesas(id),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id)
) AUTO_INCREMENT=1;