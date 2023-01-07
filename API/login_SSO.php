<?php
include_once "../cors.php";
include_once "../funciones.php";

$correo = $_POST['correo'];
$password = $_POST['contrasena'];

$errors = array();
$resultado = "";

$res = login($correo, $password);

// if ($res == 1) { //Se creo succesfully
//     $resultado = "Si se pudo";
// } else if ($res == 0) {
//     $resultado = "Contraseña incorrecta";
// } else if ($res == 2) {
//     $resultado = "La cuenta no existe";
// }

// $res = "hola";
// $res = "";
// echo $res;
echo json_encode($res);
