<?php
include_once '../classes/DetalleVenta.php';
include_once '../utils/db.php';

$action = isset($_GET['opc']) ? $_GET['opc'] : '';
$detalle_venta = new DetalleVenta($connection);

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    switch ($action) {
        case "obtener":
            $detalle_ventas = $detalle_venta->obtenerDetalleVentas();
            if (!empty($detalle_ventas)) {
                $response = array();
                foreach ($detalle_ventas as $detalle_venta) {
                    $response[] = array(
                        'id_venta' => $detalle_venta['id_venta'],
                        'nombre_vendedor' => $detalle_venta['vendedor_nombre'],
                        'apellido_vendedor' => $detalle_venta['vendedor_apellido'],
                        'producto' => $detalle_venta['producto'],
                        'cantidad' => $detalle_venta['cantidad'],
                        'total' => $detalle_venta['total'],
                        'fecha' => $detalle_venta['fecha'],
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