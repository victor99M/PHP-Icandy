<?php
include_once "../cors.php";
$data = json_decode(file_get_contents("php://input"));
include_once "../funciones.php";
$respuesta = updateProductos($data);
echo json_encode($respuesta);
