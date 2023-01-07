<?php
include_once "../cors.php";
include_once "../funciones.php";

$foto = '';

if (isset($_FILES["imagen"])) {
    $file = $_FILES["imagen"];
    $nombre_imagen = $file["name"];
    $ruta_provisional = $file["tmp_name"];
    $tipo = $file["type"];
    $carpeta = "clientes/";

    if ($tipo != 'image/JPG' && $tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif') {
    } else {
        $src = $carpeta . $nombre_imagen;
        move_uploaded_file($ruta_provisional, $src);
        $foto = "clientes/" . $nombre_imagen;
    }
}
// $foto = $_FILES['imagen']['tmp_name'];

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$direccion = $_POST['calle'];
$colonia = $_POST['colonia'];
$cp = $_POST['cp'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$contrasena = $_POST['contrasena'];

$errors = array();

if (usuarioExiste($correo)) {
    // $resultado = '{"msg":"nel"}';
    $resultado = 'Ya existe ese correou';
} else {
    $pass_hash = hashPassword($contrasena);
    $token = generateToken();
    $resultado = insertarImagen($correo, $pass_hash, $telefono, $nombre, $apellido, $foto, $direccion, $colonia, $cp, $token);

    if ($resultado > 0) {

        // $url = 'http://localhost/icandy/email/activar.php?id=' . $resultado . '&val=' . $token;

        // $asunto = "Activación de cuenta iCandy";
        // $cuerpo = "Estimadaso $nombre: <br/><br/> Se ha resgistrado, but click on the next link: <a href='$url'>Activar cuenta </a>";
    } else {
        $resultado = 'Something went wrong :(';
    }
}
// $resultado = insertarImagen($nombre, $foto);
echo $resultado;
//echo json_encode($resultado);