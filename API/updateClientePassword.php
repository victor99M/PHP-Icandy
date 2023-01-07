<?php
include_once "../cors.php";
include_once "../funciones.php";

$foto = '';

$id = $_POST['id'];
$password = $_POST['password'];

$errors = array();

$resultado = updateClientePasswor($id, $password);

if ($resultado > 0) {

    // $url = 'http://localhost/icandy/email/activar.php?id=' . $resultado . '&val=' . $token;

    // $asunto = "Activación de cuenta iCandy";
    // $cuerpo = "Estimadaso $nombre: <br/><br/> Se ha resgistrado, but click on the next link: <a href='$url'>Activar cuenta </a>";
} else {
    $resultado = 'Something went wrong :(';
}
// }
// $resultado = insertarImagen($nombre, $foto);
echo $resultado;
//echo json_encode($resultado);