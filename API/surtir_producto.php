<?php
include_once "../cors.php";
$productos_surtir = json_decode(file_get_contents("php://input"));
include_once "../funciones.php";

$resultado = surtirProductos($productos_surtir);
echo json_encode($resultado);
