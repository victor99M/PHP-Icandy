<?php
include_once "../cors.php";
$corte = json_decode(file_get_contents("php://input"));
include_once "../funciones.php";

$resultado = insertCorteCaja($corte);
echo json_encode($resultado);
