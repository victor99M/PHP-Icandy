<?php
 include_once "cors.php"; 
 //$productos = file_get_contents("php://input");
 include_once "funciones.php";
 $resultado=consultarProductos();
 echo json_encode($resultado);

?>