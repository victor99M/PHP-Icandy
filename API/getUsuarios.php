<?php
  include_once "../cors.php";
  include_once "../funciones.php";
    
  $resultado = readUsuarios();
  echo json_encode($resultado);