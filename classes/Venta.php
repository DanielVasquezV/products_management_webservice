<?php
class Venta {
    private $connection;
    public function __construct($connection) {
        $this->connection = $connection;
    }
    public function validarTotal($total){
        $pattern = '/^\d{1,10}(\.\d{1,2})?$/';
        if (preg_match($pattern, $total)) {
            return true; 
        } else {
            return false; 
        }
    }
    public function verificarVendedor($id_vendedor){
        $query = "SELECT COUNT(*) AS count FROM vendedor WHERE id_vendedor = '$id_vendedor'";
        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] == 0) {
            echo json_encode(array('error' => 'El vendedor no existe'));
            exit;
        }
    }  
    public function verificarProducto($id_producto){
        $query = "SELECT COUNT(*) AS count FROM producto WHERE id_producto = '$id_producto'";
        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] == 0) {
            echo json_encode(array('error' => 'El producto no existe'));
            exit;
        }
    }   
    
    public function insertarVenta($id_vendedor, $id_producto, $cantidad, $total, $fecha) {
        $id_vendedor = mysqli_real_escape_string($this->connection, $id_vendedor);
        $id_producto = mysqli_real_escape_string($this->connection, $id_producto);
        $cantidad = mysqli_real_escape_string($this->connection, $cantidad);
        $total = mysqli_real_escape_string($this->connection, $total);
        $fecha = mysqli_real_escape_string($this->connection, $fecha);

        // Realizar la inserción en la base de datos
        $query = "INSERT INTO venta (id_vendedor, id_producto, cantidad, total, fecha) VALUES ('$id_vendedor','$id_producto','$cantidad', '$total','$fecha')";
        $result = mysqli_query($this->connection, $query);
        return $result;
    }
    public function obtenerVentas(){
        $query = "SELECT * FROM venta";
        $result = mysqli_query($this->connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $ventas = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $ventas[] = $row;
            }
            return $ventas;
        } else {
            return array();
        }
    }
}