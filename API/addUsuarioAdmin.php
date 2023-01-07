<?php
  include_once "../cors.php";
  $usuario = json_decode(file_get_contents("php://input"));
  include_once "../funciones.php";
    
  $resultado = createUsuario($usuario);
  echo json_encode($resultado);