<?php
include_once "../cors.php";
include_once "../funciones.php";

$resultado = consultarProductos();
echo json_encode($resultado);
