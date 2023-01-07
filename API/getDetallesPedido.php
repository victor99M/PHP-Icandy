<?php
  include_once "../cors.php";
  $pedido = json_decode(file_get_contents("php://input"));
  include_once "../funciones.php";
    
  $resultado = getDetallesPedido($pedido);
  echo json_encode($resultado);