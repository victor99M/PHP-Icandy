<?php
include_once "../cors.php";
$id_PR = json_decode(file_get_contents("php://input"));
include_once "../funciones.php";
$resultado = EliminarProductoCarrito($id_PR);
echo json_encode($resultado);
