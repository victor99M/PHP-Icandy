<?php
include_once "../cors.php";
$fondo = json_decode(file_get_contents("php://input"));
include_once "../funciones.php";

$resultado = updateFondo($fondo);
echo json_encode($resultado);
