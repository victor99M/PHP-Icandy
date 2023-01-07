<?php
include_once "../cors.php";
$cierre = json_decode(file_get_contents("php://input"));
include_once "../funciones.php";

$resultado = insertCierreCaja($cierre);
echo json_encode($resultado);
