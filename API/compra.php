<?php
include_once "../cors.php";
include_once "../funciones.php";
$compra = json_decode(file_get_contents("php://input"));
include_once "../funciones.php";

$resultado = mercadoPAgo($compra);
echo json_encode($resultado);
