<?php
class Producto {
    private $connection;
    public function __construct($connection) {
        $this->connection = $connection;
    }
    public function validarPrecio($precio){
        $pattern = '/^\d{1,10}(\.\d{1,2})?$/';
        if (preg_match($pattern, $precio)) {
            return true; 
        } else {
            return false; 
        }
    }
    public function validarProductoUnico($nombre){
        $query = "SELECT COUNT(*) AS total FROM producto WHERE nombre = '$nombre'";
        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_assoc($result);
        if ($row['total'] > 0) {
            echo json_encode(array('error' => 'El producto ya existe'));
            exit;
        }
    }
    public function insertarProducto($nombre, $precio) {
        $nombre = mysqli_real_escape_string($this->connection, $nombre);
        $precio = mysqli_real_escape_string($this->connection, $precio);

        // Realizar la inserción en la base de datos
        $query = "INSERT INTO producto (nombre, precio) VALUES ('$nombre', '$precio')";
        $result = mysqli_query($this->connection, $query);
        return $result;
    }
    public function obtenerProductos(){
        $query = "SELECT * FROM producto";
        $result = mysqli_query($this->connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $productos = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $productos[] = $row;
            }
            return $productos;
        } else {
            return array();
        }
    }
}