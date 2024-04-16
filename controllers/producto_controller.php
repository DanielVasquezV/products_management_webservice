<?php
include_once '../classes/Producto.php';
include_once '../utils/db.php';

$action = isset($_GET['opc']) ? $_GET['opc'] : '';
$producto = new Producto($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case "insertar":
            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data['nombre']) || empty($data['precio'])) {
                echo json_encode(array('error' => 'Todos los campos son obligatorios'));
                exit;
            }

            $precio = $data['precio'];
            if (!$producto->validarPrecio($precio)) {
                echo json_encode(array('error' => 'El precio no es válido'));
                exit;
            }
            
            //Validar si el producto ya esta registrado
            $nombre = $data['nombre'];
            $producto->validarProductoUnico($nombre);

            $result = $producto->insertarProducto($nombre, $precio);

            if ($result) {
                echo json_encode(array('mensaje' => 'Producto insertado correctamente'));
            } else {
                echo json_encode(array('error' => 'Error al insertar el producto'));
            }
            break;
        default:
            echo json_encode(array('error' => 'Accion no valida'));
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    switch ($action) {
        case "obtener":
            $productos = $producto->obtenerProductos();
            if (!empty($productos)) {
                $response = array();
                foreach ($productos as $producto) {
                    $response[] = array(
                        'id' => $producto['id_producto'],
                        'nombre' => $producto['nombre'],
                        'precio' => $producto['precio'],
                    );
                }
                echo json_encode($response);
            } else {
                echo json_encode(array('mensaje' => 'No se encontraron registros de productos'));
            }
            break;
        default:
            echo json_encode(array('error' => 'Accion no valida'));
            break;
    }
} else {
    echo json_encode(array('error' => 'Metodo de solicitud no permitido'));
}
