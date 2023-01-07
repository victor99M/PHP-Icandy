<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Content-Type: text/html; charset=utf-8");

    $method = $_SERVER['REQUEST_METHOD'];
    
    $JSONData = file_get_contents("php://input");
    $dataObject = json_decode($JSONData);
 
    $tipo = $dataObject-> Type;
    
    function readUsuarios(){
        include 'conexion.php';
        
        //Crear Query
        $sql = "SELECT * FROM cliente";

        //Ejecutar Query
        if(!($consulta = mysqli_query($conexion, $sql))){
            echo json_encode(array('error'=>"No se pudo realizar la consulta."));
            mysqli_close($conexion);
            die();
        }

        $usuarios = array();

        while($row = $consulta -> fetch_array()){
            $id = $row['id_C'];
            $nombre = $row['nombre_C'] . ' ' . $row['apellidos_C'];
            $correo = $row['correo_C'];
            $direccion = $row['direccion_C'];
            $telefono = $row['telefono_C'];
            $tipo = $row['tipo_C'];
        
            $usuarios[] = array('id'=>$id, 'nombre'=>$nombre, 'correo'=>$correo, 'direccion'=>$direccion, 'telefono'=>$telefono, 'tipo' =>$tipo);
        }

        echo json_encode($usuarios);
        mysqli_close($conexion);
    }

    function createUsuario(){
        include 'conexion.php';
        
        //$tipo = $dataObject-> Type;

        $sql = "INSERT INTO `cliente` (`id_C`, `correo_C`, `contrasena_C`, `telefono_C`, `nombre_C`, `apellidos_C`, `foto_C`, `fecha_C`, `municipio_C`, `calle_C`, `colonia_C`, `numExt_C`, `codPos_C`, `tipo_C`) VALUES (NULL, '{}', '123', '3310445566', 'Jorge', 'Solorzano', 'null', CURRENT_DATE(), 'Zapopan', 'San Juan de Dios', 'Colinas de San Javier', '577', '33142', 'Administrador')";

        if(!($consulta = mysqli_query($conexion, $sql))){
            echo json_encode(array('error'=>"No se pudo crear el usuario."));
            mysqli_close($conexion);
            die();
        }

        echo json_encode(array("success"=>"Se ha creado el usuario exitosamente."));
    }  

    if($tipo == 'Read')
        readUsuarios();
    else if($tipo == 'Create')
        createUsuario();
?>