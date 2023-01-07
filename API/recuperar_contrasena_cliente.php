<?php
include_once "../cors.php";
include_once "../funciones.php";

define('host', 'localhost');
define('user', 'root');
define('pass', '');
define('name', 'icandy');

$conexion = new mysqli(host, user, pass, name);

$correo = $_POST['correo'];

$errors = array();
$resultado = "";

// $miConexion = conexionMiguel();

if (usuarioExiste_($correo)) {

    $id_Cliente = getValores_('id_C', 'correo_C', $correo);
    $nombre_Cliente = getValores_('nombre_C', 'correo_C', $correo);

    $contrasena_temp_C = generateTemporalPassword(15);
    $new_pass_hash = hashPassword($contrasena_temp_C);

    $token = generateToken_for_password_($id_Cliente, $new_pass_hash);

    // $sql = "UPDATE cliente SET password_temp_C = $new_pass_hash WHERE id_C = $id_Cliente";


    // $url = 'localhost://localhost/icandy//change_password.php?id_C=' . $id_Cliente . '&token=' . $token;
    $url = 'http://localhost:3000';
    //http://localhost/icandy/prueba.php

    $asunto = "Recuperacion de cuenta iCandy";

    $cuerpo = "Estimado $nombre_Cliente, <br/><br/>
    Haz solicitado realizar el cambio de contraseña para recuperar tu cuenta.
    Para continuar con el proceso, utiliza el siguiente código como contraseña:
    <b> $contrasena_temp_C </b>
    <br/><br/>
    Por seguridad una vez que ingreses al sistema, será necesario cambiar tu contraseña.

    <br/><br/><br/>
    Si no realizaste esta acción, no realices ninguna acción.
    ";
    //$resultado = $nombre_Cliente;

    $request_enviar_correo = enviarCorreo($correo, $asunto, $cuerpo);

    if ($request_enviar_correo == 1) {
        $resultado = "Uno";
    } else if ($request_enviar_correo == 0) {
        $resultado = "Ocurrió un error";
    } else {
        $resultado = "nadaa";
    }
} else {
    $resultado = "No existe una cuenta vicnculada a este correo.";
}

echo $resultado;


function usuarioExiste_($correo)
{
    global $conexion;

    $stmt = $conexion->prepare("SELECT correo_C FROM cliente WHERE correo_C = ? LIMIT 1");

    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    $stmt->close();
    if ($num > 0) {
        //$conexion->close();
        return true;
    } else {
        //$conexion->close();
        return false;
    }
}


function getValores_($campo, $campoCondicion, $valor) //id_C, correo_C, $correo (algo@gmail.com)
{
    global $conexion;

    $stmt = $conexion->prepare("SELECT $campo FROM cliente WHERE $campoCondicion = ? LIMIT 1");
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;

    if ($num > 0) {
        $stmt->bind_result($campo_returned);
        $stmt->fetch();
        //  $conexion->close();
        return $campo_returned;
    } else {
    }
}


function generateToken_for_password_($id_C, $new_pass_hash)
{
    global $conexion;
    $token = generateToken_();
    $stmt = $conexion->prepare("UPDATE cliente SET token_password_C=?, password_request_C=1, password_requested_C=? WHERE id_C=?");
    $stmt->bind_param('sss', $token, $new_pass_hash, $id_C);

    // $stmt = $conexion->prepare("UPDATE cliente SET token_password_C=?, password_request_C=1, password_requested_C=? WHERE id_C=?");
    // $stmt->bind_param('sss', $token, $id_C, $new_pass_hash);

    $stmt->execute();
    $stmt->close();

    return $token;
}

function generateToken_()
{
    $gen = md5(uniqid(mt_rand(), false));
    return $gen;
}
