<?php
include_once "../cors.php";
$carrito = json_decode(file_get_contents("php://input"));
include_once "../funciones.php";

$resultado = RealizarCompra($carrito);
echo json_encode($resultado);
