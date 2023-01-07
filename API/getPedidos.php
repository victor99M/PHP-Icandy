<?php
  include_once "../cors.php";
  include_once "../funciones.php";
    
  $resultado = getPedidos();
  echo json_encode($resultado);