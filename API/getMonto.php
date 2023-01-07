<?php
include_once "../cors.php";
include_once "../funciones.php";

$resultado = getMonto();
echo json_encode($resultado);
