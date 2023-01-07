<?php
include_once "../cors.php";
$id_C = json_decode(file_get_contents("php://input"));
include_once "../funciones.php";
$resultado = consultaCarrito($id_C);
echo json_encode($resultado);
