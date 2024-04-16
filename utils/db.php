<?php
$host = "localhost";
$user = "root";
$password = "12345";
$database_name = "products_ws_bd";

$connection = mysqli_connect($host, $user, $password, $database_name);

if (!$connection) {
    die("Error de conexión: ". mysqli_connect_error());
}