<?php
include_once "../cors.php";
$añadir = json_decode(file_get_contents("php://input"));
include_once "../funciones.php";

$resultado = addCarrito($añadir);
echo json_encode($resultado);
