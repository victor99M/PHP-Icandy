<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-Type: text/html; charset=utf-8");

$method = $_SERVER['REQUEST_METHOD'];

$JSONData = file_get_contents("php://input");
$dataObject = json_decode($JSONData);

$tipo = $dataObject->Type;

function readProductos()
{
    include '../conexion.php';

    //Crear Query
    $sql = "SELECT * FROM producto WHERE discontinuo_PR='0' ";

    //Ejecutar Query
    if (!($consulta = mysqli_query($conexion, $sql))) {
        echo json_encode(array('error' => "No se pudo realizar la consulta."));
        mysqli_close($conexion);
        die();
    }

    $productos = array();

    while ($row = $consulta->fetch_array()) {
        $id_PR = $row['id_PR'];
        $nombre_PR = $row['nombre_PR'];
        $cantidad_PR = $row['cantidad_PR'];
        $precio_PR = $row['precio_PR'];
        $inversion_PR = $row['inversion_PR'];
        $descripcion_PR = $row['descripcion_PR'];
        $novedad_PR = $row['novedad_PR'];
        $discontinuo_PR = $row['discontinuo_PR'];
        $unidadPeso_PR = $row['unidadPeso_PR'];
        $piezasCaja_PR = $row['piezasCaja_PR'];
        $foto_PR = $row['foto_PR'];


        $productos[] = array('id_PR' => $id_PR, 'nombre_PR' => $nombre_PR, 'cantidad_PR' => $cantidad_PR, 'precio_PR' => $precio_PR, 'inversion_PR' => $inversion_PR, 'descripcion_PR' => $descripcion_PR, 'novedad_PR' => $novedad_PR, 'discontinuo_PR' => $discontinuo_PR, 'unidadPeso_PR' => $unidadPeso_PR, 'piezasCaja_PR' => $piezasCaja_PR, 'foto_PR' => $foto_PR);
    }

    echo json_encode($productos);
    mysqli_close($conexion);
}

if ($tipo == 'Read')
    readProductos();
