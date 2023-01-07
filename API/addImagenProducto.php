<?php
include_once "../cors.php";
include_once "../funciones.php";

$foto = '';

if (isset($_FILES["url_imagen"])) {
    $file = $_FILES["url_imagen"];
    $nombre_imagen = $file["name"];
    $ruta_provisional = $file["tmp_name"];
    $tipo = $file["type"];
    $carpeta = "productos/";

    if ($tipo != 'image/JPG' && $tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif') {
    } else {
        $src = $carpeta . $nombre_imagen;
        move_uploaded_file($ruta_provisional, $src);
        $foto = $nombre_imagen;
    }
}
// $foto = $_FILES['imagen']['tmp_name'];

$resultado = insertarImagenProductos($foto);

if ($resultado > 0) {
} else {
    $resultado = 'Something went wrong :(';
}

// $resultado = insertarImagen($nombre, $foto);
echo $resultado;
//echo json_encode($resultado);