<?php
class DetalleVenta {
    private $connection;
    public function __construct($connection) {
        $this->connection = $connection;
    }
    public function obtenerDetalleVentas(){
        $query = "SELECT venta.id_venta, vendedor.nombre AS vendedor_nombre, vendedor.apellido AS vendedor_apellido, pr.nombre AS producto, venta.cantidad, venta.total, venta.fecha FROM venta venta JOIN vendedor vendedor ON venta.id_vendedor = vendedor.id_vendedor JOIN producto pr ON venta.id_producto = pr.id_producto";

        $result = mysqli_query($this->connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $vendedores = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $vendedores[] = $row;
            }
            return $vendedores;
        } else {
            return array();
        }
    }
}