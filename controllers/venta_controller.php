<?php
include_once '../classes/Venta.php';
include_once '../utils/db.php';

$action = isset($_GET['opc']) ? $_GET['opc'] : '';
$venta = new Venta($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case "insertar":
            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data['id_vendedor']) || empty($data['id_producto']) || empty($data['cantidad']) || empty($data['total']) || empty($data['fecha'])) {
                echo json_encode(array('error' => 'Todos los campos son obligatorios'));
                exit;
            }

            $total = $data['total'];
            if (!$venta->validarTotal($total)) {
                echo json_encode(array('error' => 'El total no es válido'));
                exit;
            }

            $id_vendedor = $data['id_vendedor'];
            $venta->verificarVendedor($id_vendedor);

            $id_producto = $data['id_producto'];
            $venta->verificarProducto($id_producto);

            $result = $venta->insertarVenta($id_vendedor, $id_producto, $data['cantidad'], $data['total'], $data['fecha']);

            if ($result) {
                echo json_encode(array('mensaje' => 'Venta registrada correctamente'));
            } else {
                echo json_encode(array('error' => 'Error al registrar la venta'));
            }
            break;
        default:
            echo json_encode(array('error' => 'Accion no valida'));
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    switch ($action) {
        case "obtener":
            $ventas = $venta->obtenerVentas();
            if (!empty($ventas)) {
                $response = array();
                foreach ($ventas as $venta) {
                    $response[] = array(
                        'id_venta' => $venta['id_venta'],
                        'id_vendedor' => $venta['id_vendedor'],
                        'id_producto' => $venta['id_producto'],
                        'cantidad' => $venta['cantidad'],
                        'total' => $venta['total'],
                        'fecha' => $venta['fecha'],
                    );
                }
                echo json_encode($response);
            } else {
                echo json_encode(array('mensaje' => 'No se encontraron registros de ventas'));
            }
            break;
        default:
            echo json_encode(array('error' => 'Accion no valida'));
            break;
    }
} else {
    echo json_encode(array('error' => 'Metodo de solicitud no permitido'));
}