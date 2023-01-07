<?php
include_once "../cors.php";
include_once "../funciones.php";

$foto = '';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$direccion = $_POST['direccion'];
$colonia = $_POST['colonia'];
$cp = $_POST['cp'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];

$errors = array();

// if (usuarioExiste($correo)) {
//     // $resultado = '{"msg":"nel"}';
//     $resultado = 'Ya existe ese correou';
// } else {

$resultado = updatePerfilCliente($nombre, $apellido, $direccion, $colonia, $cp, $correo, $telefono, $id);

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