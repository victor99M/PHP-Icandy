<?php
include_once "../cors.php";
include_once "../funciones.php";

$id_C = $_POST['id_C'];

$errors = array();
$resultado = "";

$res = getDataUsuario($id_C);

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


// echo $res;
