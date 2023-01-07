<?php
include_once "../cors.php";
include_once "../funciones.php";

$resultado = getCorteCaja();
echo json_encode($resultado);
