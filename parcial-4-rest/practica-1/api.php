<?php
header("Content-Type: application/json");

$metodo = $_SERVER['REQUEST_METHOD'];

$datos = [
    ["id" => 1, "nombre" => "Producto 1"],
    ["id" => 2, "nombre" => "Producto 2"]
];

switch ($metodo) {
    case 'GET':
        echo json_encode($datos);
        break;

    case 'POST':
        echo json_encode(["mensaje" => "Registro creado"]);
        break;

    case 'PUT':
        echo json_encode(["mensaje" => "Registro actualizado"]);
        break;

    case 'DELETE':
        echo json_encode(["mensaje" => "Registro eliminado"]);
        break;

    default:
        echo json_encode(["mensaje" => "Método no permitido"]);
}
