<?php
class Vendedor {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function insertarVendedor($nombre, $apellido, $email) {
        $nombre = mysqli_real_escape_string($this->connection, $nombre);
        $apellido = mysqli_real_escape_string($this->connection, $apellido);
        $email = mysqli_real_escape_string($this->connection, $email);

        // Realizar la inserción en la base de datos
        $query = "INSERT INTO vendedor (nombre, apellido, email) VALUES ('$nombre', '$apellido', '$email')";
        $result = mysqli_query($this->connection, $query);
        return $result;
    }
    // Validar si ya existe un vendedor con el mismo email
    public function validarVendedorUnico($email){
        $query = "SELECT COUNT(*) AS total FROM vendedor WHERE email = '$email'";
        $result = mysqli_query($this->connection, $query);
        $row = mysqli_fetch_assoc($result);
        if ($row['total'] > 0) {
            echo json_encode(array('error' => 'El vendedor ya existe'));
            exit;
        }
    }
    //Obtener todos los vendedores
    public function obtenerVendedores(){
        $query = "SELECT * FROM vendedor";
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
