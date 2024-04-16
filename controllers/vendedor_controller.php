<?php
include_once '../classes/Vendedor.php';
include_once '../utils/db.php';

$action = isset($_GET['opc']) ? $_GET['opc'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case "insertar":
            $data = json_decode(file_get_contents("php://input"), true);

            if (empty($data['nombre']) || empty($data['apellido']) || empty($data['email'])) {
                echo json_encode(array('error' => 'Todos los campos son obligatorios'));
                exit;
            }

            $email = $data['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(array('error' => 'El email proporcionado no es válido'));
                exit;
            }
            
            $vendedor = new Vendedor($connection);

            //Validar si el email ya esta registrado
            $vendedor->validarVendedorUnico($email);

            $result = $vendedor->insertarVendedor($data['nombre'], $data['apellido'], $email);

            if ($result) {
                echo json_encode(array('mensaje' => 'Vendedor insertado correctamente'));
            } else {
                echo json_encode(array('error' => 'Error al insertar vendedor'));
            }
            break;
        default:
            echo json_encode(array('error' => 'Accion no valida'));
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    switch ($action) {
        case "obtener":
            $vendedor = new Vendedor($connection);
            $vendedores = $vendedor->obtenerVendedores();
            if (!empty($vendedores)) {
                $response = array();
                foreach ($vendedores as $vendedor) {
                    $response[] = array(
                        'id' => $vendedor['id_vendedor'],
                        'nombre' => $vendedor['nombre'],
                        'apellido' => $vendedor['apellido'],
                        'email' => $vendedor['email']
                    );
                }
                echo json_encode($response);
            } else {
                echo json_encode(array('mensaje' => 'No se encontraron registros de vendedores'));
            }
            break;
        default:
            echo json_encode(array('error' => 'Accion no valida'));
            break;
    }
} else {
    echo json_encode(array('error' => 'Metodo de solicitud no permitido'));
}
