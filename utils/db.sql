CREATE SCHEMA IF NOT EXISTS products_ws_bd;
USE products_ws_bd;
CREATE TABLE vendedor (
    id_vendedor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE producto (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL
);

CREATE TABLE venta (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    id_vendedor INT,
    id_producto INT,
    cantidad INT,
    total DECIMAL(10, 2),
    fecha VARCHAR(100),
    FOREIGN KEY (id_vendedor) REFERENCES vendedor(id_vendedor),
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto)
);
DROP TABLE venta;

DROP SCHEMA products_ws_bd;

SELECT venta.id_venta, vendedor.nombre AS vendedor_nombre, vendedor.apellido AS vendedor_apellido, pr.nombre AS producto, venta.cantidad, venta.total, venta.fecha FROM venta venta JOIN vendedor vendedor ON venta.id_vendedor = vendedor.id_vendedor JOIN producto pr ON venta.id_producto = pr.id_producto