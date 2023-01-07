<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
///////////////////////////////////////////////////
///////////////// Victor Sandoval /////////////////
///////////////////////////////////////////////////
function consultarProductos()
{
    include("conexion.php");
    //consulta
    $sql = "SELECT * FROM producto";
    $result = mysqli_query($conexion, $sql);
    $json_array = array();
    if (isset($result)) {


        while ($fila = mysqli_fetch_assoc($result)) {
            $json_array[] = $fila;
        }
        //retornamos el arreglo con los datos de la consulta
        return $json_array;
        mysqli_close($conexion);
    } else {
        return 0;
        mysqli_close($conexion);
    }
}

function actualizarProducto($carrito)
{
    include("conexion.php");
    //insertamos en ventaPedido
    $insertVentaPedido = "INSERT INTO `venta_pedido` (fecha_VP,fechaDeEntrega_VP,	tipoVenta_VP,estado_VP,inversion_VP,total_VP,corte_VP,cierre_VP) 
    VALUES (  CURRENT_DATE(), CURRENT_DATE() ,'Fisica','Entregado',$carrito->inversion_total,$carrito->totalCompra,0,0)";
    $result = mysqli_query($conexion, $insertVentaPedido);

    if ($result) {
        //obtenemos el ultimo id insertado para poder utilizarlo para hacer lo insert restantes
        $id_VP = mysqli_insert_id($conexion);
        //insertamos en ventaCarrito
        $insertVentaCarrito = "INSERT INTO `venta_carrito` (id_C, id_VP)
        VALUES ($carrito->id_cliente,$id_VP)";
        if (!mysqli_query($conexion, $insertVentaCarrito)) {
            mysqli_close($conexion);
            return 0;
        }
        //reducimos la cantidad del carrito y agregamos cada uno de los productos a detalles
        foreach ($carrito->productos as $index => $objecto) {
            $nuevaCantidad = 0;
            $nuevaCantidad = $objecto->cantidad_PR - $objecto->unidades;
            $actualizarCantidad = "UPDATE producto SET cantidad_PR=$nuevaCantidad where id_PR = $objecto->id_PR";
            $insertarDetalles = "INSERT INTO `detalles` (cantidad_D,id_PR,total_D,inversion_D,id_VP)
            VALUES ($objecto->unidades,$objecto->id_PR,$objecto->total,$objecto->inversion_PR*$objecto->unidades,$id_VP)";

            if (!mysqli_query($conexion, $actualizarCantidad) || !mysqli_query($conexion, $insertarDetalles)) {
                mysqli_close($conexion);
                return 0;
            }
        }
    } else {
        mysqli_close($conexion);
        return 0;
    }



    return 1;
    mysqli_close($conexion);
}

function insertarCarrito($carrito)
{
    include("conexion.php");

    $busqueda = "SELECT * FROM genera_carrito WHERE id_PR= $carrito->id_PR and id_C=$carrito->id_C";
    $Verificar_producto = mysqli_query($conexion, $busqueda);
    $row = $Verificar_producto->fetch_array();
    if (mysqli_num_rows($Verificar_producto) > 0 && $carrito->cantidad_PR > 0) {
        if ($carrito->estado == "detalles") {
            $actualizar_cantidad = "UPDATE genera_carrito set cantidad_CA=$carrito->cantidad_PR WHERE id_PR= $carrito->id_PR and id_C=$carrito->id_C";
            mysqli_query($conexion, $actualizar_cantidad);
            mysqli_close($conexion);
            return true;
        } else if ($carrito->estado == "carrito") {
            //se actualiza la cantidad cada vez que se preciona el boton de agregar ala carrito
            $actualizar_cantidad = "UPDATE genera_carrito set cantidad_CA=$row[3]+1 WHERE id_PR= $carrito->id_PR and id_C=$carrito->id_C";
            mysqli_query($conexion, $actualizar_cantidad);
            mysqli_close($conexion);
            return true;
        }
    } else {
        if ($carrito->estado == "detalles") {

            if ($carrito->cantidad_PR > 0) {
                $sql = "INSERT INTO `genera_carrito` (id_C,id_PR,cantidad_CA) 
            VALUES ($carrito->id_C,$carrito->id_PR,$carrito->cantidad_PR)";
            } else if ($carrito->cantidad == 0) {
                $sql = "DELETE FROM genera_carrito WHERE id_C=$carrito->id_C and id_PR=$carrito->id_PR";
            }

            $insert = mysqli_query($conexion, $sql);
            if (isset($insert)) {
                mysqli_close($conexion);
                return true;
            } else {
                mysqli_close($conexion);
                return false;
            }
        } else if ($carrito->estado == "carrito") {
            $sql = "INSERT INTO `genera_carrito` (id_C,id_PR,cantidad_CA) 
            VALUES ($carrito->id_C,$carrito->id_PR,$carrito->cantidad_PR)";
            $insert = mysqli_query($conexion, $sql);
            if (isset($insert)) {
                mysqli_close($conexion);
                return true;
            } else {
                mysqli_close($conexion);
                return false;
            }
        }
    }
}

function consultaCarrito($id)
{
    include("conexion.php");
    $sql = "SELECT * FROM producto p
    JOIN genera_carrito gc
    On p.id_PR= gc.id_PR
    WHERE gc.id_C=$id->id_C";
    $result = mysqli_query($conexion, $sql);
    $json_array = array();
    if (isset($result)) {
        while ($fila = mysqli_fetch_assoc($result)) {
            $json_array[] = $fila;
        }

        // $json_array[] = array('cantidad' => $cont);
        //retornamos el arreglo con los datos de la consulta
        mysqli_close($conexion);
        return $json_array;
    } else {
        mysqli_close($conexion);
        return 0;
    }
}

function EliminarProductoCarrito($id)
{
    include("conexion.php");
    $sql = "DELETE FROM genera_carrito WHERE id_PR=$id->id_PR";
    $result = mysqli_query($conexion, $sql);

    if (isset($result)) {
        mysqli_close($conexion);
        return true;
    } else {
        mysqli_close($conexion);
        return false;
    }
}

function addCarrito($carrito)
{
    include("conexion.php");
    if ($carrito->Type == "Agregar") {
        if ($carrito->Productos->cantidad_CA < $carrito->Productos->cantidad_PR) {
            $agregarCarritoCantidad = "UPDATE genera_carrito set cantidad_CA={$carrito->Productos->cantidad_CA}+1 WHERE id_PR= {$carrito->Productos->id_PR} and id_C= {$carrito->Productos->id_C}";
            mysqli_query($conexion, $agregarCarritoCantidad);
            mysqli_close($conexion);
            return true;
        } else {
            return false;
        }
    } else if ($carrito->Type == "Quitar") {
        if ($carrito->Productos->cantidad_CA > 1) {
            $agregarCarritoCantidad = "UPDATE genera_carrito set cantidad_CA={$carrito->Productos->cantidad_CA}-1 WHERE id_PR= {$carrito->Productos->id_PR} and id_C= {$carrito->Productos->id_C}";
            mysqli_query($conexion, $agregarCarritoCantidad);
            mysqli_close($conexion);
            return true;
        } else {
            return false;
        }
    }
}


function updateFondo($fondo)
{
    include("conexion.php");
    $actualizarFondo = "UPDATE fondo set cantidad_FC=$fondo->fondo,token_FC=false WHERE id_FC=1";
    if (mysqli_query($conexion, $actualizarFondo)) {
        mysqli_close($conexion);
        return 1;
    } else {
        return 0;
    }
}

function insertCorteCaja($corte)
{
    include("conexion.php");
    $insertCorte = "INSERT INTO corte_caja (usuario_corte,fecha_corte,hora_corte,caja_corte,monto_corte,diferencia_corte,token_corte) 
    VALUES ('{$corte->usuario}',CURRENT_DATE(),CURTIME(),{$corte->caja},{$corte->venta},{$corte->diferencia},0)";
    $tokencorte = "UPDATE venta_pedido set corte_VP=true WHERE corte_VP=0 and cierre_VP=0";

    if (mysqli_query($conexion, $insertCorte)) {

        if (mysqli_query($conexion, $tokencorte)) {
            mysqli_close($conexion);
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function getMonto()
{
    include("conexion.php");
    $ObtenerMonto = "SELECT * from venta_pedido WHERE corte_VP=false";
    $total = 0;
    $consulta = mysqli_query($conexion, $ObtenerMonto);
    if ($consulta) {
        while ($row = mysqli_fetch_array($consulta)) {
            $total += $row['total_VP'];
        }
        mysqli_close($conexion);
        return $total;
    } else {
        return false;
    }
}


function getCorteCaja()
{
    include("conexion.php");
    //consulta
    $sql = "SELECT * FROM corte_caja";
    $result = mysqli_query($conexion, $sql);
    $json_array = array();
    if (isset($result)) {
        while ($fila = mysqli_fetch_assoc($result)) {
            $json_array[] = $fila;
        }
        //retornamos el arreglo con los datos de la consulta
        return $json_array;
        mysqli_close($conexion);
    } else {
        return 0;
        mysqli_close($conexion);
    }
}

function insertCierreCaja($corte)
{
    include "conexion.php";
    $ObtenerMonto = "SELECT * from corte_caja";

    $total_caja = 0;
    $total_monto = 0;
    $total_diferencia = 0;

    $consulta = mysqli_query($conexion, $ObtenerMonto);
    if ($consulta) {
        while ($row = mysqli_fetch_array($consulta)) {
            $total_caja += $row['caja_corte'];
            $total_monto += $row['monto_corte'];
            $total_diferencia += $row['diferencia_corte'];
        }
        $insertarCierre = "INSERT INTO cierre_caja (id_C,hora_CC,fecha_CC,caja_CC,monto_CC,diferencia_CC) 
        VALUES ({$corte->id_c},CURTIME(),CURRENT_DATE(),{$total_caja},{$total_monto},{$total_diferencia})";
        $deletCorteCaja = "DELETE FROM corte_caja";
        if (mysqli_query($conexion, $insertarCierre) && mysqli_query($conexion, $deletCorteCaja)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function mercadoPAgo($compra)
{

    //curl -X POST -H "Content-Type: application/json" "https://api.mercadopago.com/users/test_user?access_token=TEST-1099575392435024-022319-f69d8af302c599c914fa625d53d5815e-235288542" -d "{'site_id':'MLM'}"
    //{"id":1106764165,"nickname":"TETE7347450","password":"qatest5912","site_status":"active","email":"test_user_49897588@testuser.com"} clinete
    //{"id":1106760644,"nickname":"TEST40KZFEEK","password":"qatest9538","site_status":"active","email":"test_user_24177981@testuser.com"} vendedor
    // SDK de Mercado Pago

    require __DIR__ .  '/vendor/autoload.php';

    // Agrega credenciales
    MercadoPago\SDK::setAccessToken('TEST-6207672892080452-041823-1d5a8dc598dd006552a536f55535613d-1106760644');

    // Crea un objeto de preferencia
    $preference = new MercadoPago\Preference();
    $preference->back_urls = array(
        "success" => "http://localhost:3000/carrito",
        "failure" => "http://www.tu-sitio/failure",
        "pending" => "http://www.tu-sitio/pending"
    );
    $preference->auto_return = "approved";

    $datos = array();
    foreach ($compra as $objecto) {
        // Crea un ítem en la preferencia
        $item = new MercadoPago\Item();
        $item->title = $objecto->nombre_PR;
        $item->quantity = $objecto->cantidad_CA;
        $item->unit_price = $objecto->precio_PR;
        $datos[] = $item;
    }
    $preference->items = $datos;
    $preference->save();
    return $preference->id;
}

function RealizarCompra($carrito)
{
    include("conexion.php");
    if ($carrito->inversion_total > 0) {
        //insertamos en ventaPedido
        $insertVentaPedido = "INSERT INTO `venta_pedido` (fecha_VP,fechaDeEntrega_VP,	tipoVenta_VP,estado_VP,inversion_VP,total_VP,corte_VP,cierre_VP) 
    VALUES (  CURRENT_DATE(), CURRENT_DATE() ,'Digital','Pendiente',$carrito->inversion_total,$carrito->totalCompra,1,1)";
        $result = mysqli_query($conexion, $insertVentaPedido);


        if ($result) {
            //obtenemos el ultimo id insertado para poder utilizarlo para hacer lo insert restantes
            $id_VP = mysqli_insert_id($conexion);
            //insertamos en ventaCarrito
            $insertVentaCarrito = "INSERT INTO `venta_carrito` (id_C, id_VP)
        VALUES ($carrito->id_cliente,$id_VP)";
            if (!mysqli_query($conexion, $insertVentaCarrito)) {
                mysqli_close($conexion);
                return false;
            } else {
                //reducimos la cantidad del carrito y agregamos cada uno de los productos a detalles
                foreach ($carrito->productos as $index => $objecto) {
                    $nuevaCantidad = 0;
                    $nuevaCantidad = $objecto->cantidad_PR - $objecto->cantidad_CA;
                    $actualizarCantidad = "UPDATE producto SET cantidad_PR=$nuevaCantidad where id_PR = $objecto->id_PR";
                    $insertarDetalles = "INSERT INTO `detalles` (cantidad_D,id_PR,total_D,inversion_D,id_VP)
            VALUES ($objecto->cantidad_CA,$objecto->id_PR,$objecto->cantidad_CA*$objecto->precio_PR,$objecto->inversion_PR*$objecto->cantidad_CA,$id_VP)";

                    if (!mysqli_query($conexion, $actualizarCantidad) || !mysqli_query($conexion, $insertarDetalles)) {
                        mysqli_close($conexion);
                        return false;
                    }
                }
                $vaciarCarrito = "DELETE FROM genera_carrito WHERE id_C=$carrito->id_cliente";
                if (!mysqli_query($conexion, $vaciarCarrito)) {
                    mysqli_close($conexion);
                    return false;
                }
                mysqli_close($conexion);
                return 1;
            }
        } else {
            mysqli_close($conexion);
            return false;
        }



        return 1;
        mysqli_close($conexion);
    } else {
        return false;
    }
}

function obtenerCliente($id_cliente)
{
    include("conexion.php");
    //consulta
    $sql = "SELECT * FROM cliente where id_C=$id_cliente->id_cliente";
    $result = mysqli_query($conexion, $sql);
    $json_array = array();
    if (isset($result)) {


        while ($fila = mysqli_fetch_assoc($result)) {
            $json_array[] = $fila;
        }
        //retornamos el arreglo con los datos de la consulta
        return $json_array;
        mysqli_close($conexion);
    } else {
        return 0;
        mysqli_close($conexion);
    }
}

///////////////////////////////////////////////////
////////////////// Karl Scherzer //////////////////
///////////////////////////////////////////////////

function readUsuarios()
{
    include 'conexion.php';

    //Crear Query
    $sql = "SELECT * FROM cliente";

    //Ejecutar Query
    if (!($consulta = mysqli_query($conexion, $sql))) {
        mysqli_close($conexion);
        return array('error' => "No se pudo realizar la consulta.");
    }

    $usuarios = array();

    while ($row = $consulta->fetch_array()) {
        $id = $row['id_C'];
        $nombre = $row['nombre_C'] . ' ' . $row['apellidos_C'];
        $correo = $row['correo_C'];
        $direccion = $row['direccion_C'] . ' ' . $row['colonia_C'] . ' ' . $row['cp_C'];
        $telefono = $row['telefono_C'];
        $tipo = $row['tipo_C'];

        $usuarios[] = array('id' => $id, 'nombre' => $nombre, 'correo' => $correo, 'direccion' => $direccion, 'telefono' => $telefono, 'tipo' => $tipo);
    }

    mysqli_close($conexion);
    return $usuarios;
}

function createUsuario($usuario)
{
    include 'conexion.php';

    $nombre = $usuario->nombre;
    $apellido = $usuario->apellido;
    $direccion = $usuario->direccion;
    $correo = $usuario->correo;
    $telefono = $usuario->telefono;
    $clave = $usuario->clave;

    filter_input(INPUT_POST, $nombre);
    filter_input(INPUT_POST, $apellido);
    filter_input(INPUT_POST, $direccion);
    filter_input(INPUT_POST, $correo);
    filter_input(INPUT_POST, $telefono);
    filter_input(INPUT_POST, $clave);

    $sql = "INSERT INTO `cliente` (`id_C`, `correo_C`, `contrasena_C`, `telefono_C`, `nombre_C`, `apellidos_C`, `foto_C`, `fecha_C`, `direccion_C`, `tipo_C`) VALUES (NULL, '{$correo}', '{$clave}', '{$telefono}', '{$nombre}', '{$apellido}', 'null', CURRENT_DATE(), '{$direccion}', 'Vendedor')";

    if (!($consulta = mysqli_query($conexion, $sql))) {
        mysqli_close($conexion);
        return array('error' => "No se pudo crear el usuario.");
    }

    mysqli_close($conexion);
    return array("success" => "Se ha creado el usuario exitosamente.");
}

function getPedidos()
{
    include 'conexion.php';

    //Crear Query
    $sql = "SELECT venta_pedido.id_VP, cliente.nombre_C, cliente.apellidos_C, venta_pedido.estado_VP, venta_pedido.fecha_VP, venta_pedido.fechaDeEntrega_VP FROM (cliente INNER JOIN venta_carrito on venta_carrito.id_C = cliente.id_C) INNER JOIN venta_pedido ON venta_pedido.id_VP = venta_carrito.id_VP";

    //Ejecutar Query
    if (!($consulta = mysqli_query($conexion, $sql))) {
        mysqli_close($conexion);
        return array('error' => "No se pudo realizar la consulta.");
    }

    while ($fila = mysqli_fetch_assoc($consulta)) {
        $json_array[] = $fila;
    }

    mysqli_close($conexion);
    return $json_array;
}

function getDetallesPedido($pedido)
{
    include 'conexion.php';

    $pedidoID = $pedido->pedidoID;

    $sql = "SELECT producto.id_PR, producto.nombre_PR, producto.precio_PR, producto.unidadPeso_PR, detalles.cantidad_D, detalles.total_D FROM producto INNER JOIN detalles ON detalles.id_PR = producto.id_PR WHERE id_VP='{$pedidoID}'";

    //Ejecutar Query
    if (!($consulta = mysqli_query($conexion, $sql))) {
        mysqli_close($conexion);
        return array('error' => "No se pudo realizar la consulta.");
    }

    while ($fila = mysqli_fetch_assoc($consulta)) {
        $productos[] = $fila;
    }

    $sql = "SELECT venta_pedido.id_VP, cliente.nombre_C, cliente.apellidos_C, cliente.telefono_C, venta_pedido.estado_VP,  venta_pedido.fecha_VP, venta_pedido.fechaDeEntrega_VP,  cliente.direccion_C, cliente.colonia_C, cliente.cp_C, venta_pedido.total_VP FROM (cliente INNER JOIN venta_carrito on venta_carrito.id_C = cliente.id_C) INNER JOIN venta_pedido ON venta_pedido.id_VP = venta_carrito.id_VP WHERE venta_pedido.id_VP='{$pedidoID}'";

    //Ejecutar Query
    if (!($consulta = mysqli_query($conexion, $sql))) {
        mysqli_close($conexion);
        return array('error' => "No se pudo realizar la consulta.");
    }

    while ($fila = mysqli_fetch_assoc($consulta)) {
        $detalles[] = $fila;
    }

    $detalles[0]['direccion_C'] .= ' ' . $detalles[0]['colonia_C'] . ' ' . $detalles[0]['cp_C'];

    $json_array = array('detalles' => $detalles, 'productos' => $productos);

    mysqli_close($conexion);
    return $json_array;
}

function updatePedido($pedido)
{
    include 'conexion.php';

    $id = $pedido->id_VP;
    $status = $pedido->status;
    $fechaDeEntrega = $pedido->fechaEntrega;

    //Crear Query
    $sql = "UPDATE venta_pedido SET estado_VP = '{$status}', fechaDeEntrega_VP = '{$fechaDeEntrega}' WHERE id_VP = '{$id}'";

    //Ejecutar Query
    if (!($consulta = mysqli_query($conexion, $sql))) {
        mysqli_close($conexion);
        return array('error' => "No se pudo realizar la consulta.");
    }

    mysqli_close($conexion);
    return array("success" => "Se ha modificado el pedido exitosamente.");
}

function getProductoDetalles($producto)
{
    include 'conexion.php';

    $id = $producto->id;
    $id_c = $producto->id_c;
    //Crear Query
    //$sql = "SELECT id_PR, novedad_PR, foto_PR, nombre_PR, unidadPeso_PR, nombreDescripcion_PR, precio_PR, cantidad_PR FROM producto WHERE id_PR='{$id}'";
    $sql = "SELECT * FROM producto WHERE id_PR='{$id}'";

    //Ejecutar Query
    if (!($consulta = mysqli_query($conexion, $sql))) {
        mysqli_close($conexion);
        return array('error' => "No se pudo realizar la consulta.");
    }

    while ($fila = mysqli_fetch_assoc($consulta)) {
        $productoPedido[] = $fila;
    }

    $sql = "SELECT id_PR, novedad_PR, foto_PR, nombre_PR, unidadPeso_PR, nombreDescripcion_PR, precio_PR, cantidad_PR FROM producto WHERE (discontinuo_PR = 0) AND (cantidad_PR > 0) AND (id_PR != '{$id}') ORDER BY rand() LIMIT 3";

    //Ejecutar Query
    if (!($consulta = mysqli_query($conexion, $sql))) {
        mysqli_close($conexion);
        return array('error' => "No se pudo realizar la consulta.");
    }

    while ($fila = mysqli_fetch_assoc($consulta)) {
        $relacionados[] = $fila;
    }


    $sql = "SELECT * FROM genera_carrito WHERE id_C=$id_c and id_PR=$id";
    //Ejecutar Query
    if (!($consulta = mysqli_query($conexion, $sql))) {
        mysqli_close($conexion);
        return array('error' => "No se pudo realizar la consulta.");
    }
    $rowcount = mysqli_num_rows($consulta);

    if ($rowcount > 0) {
        while ($fila = mysqli_fetch_assoc($consulta)) {
            $carrito1[] = $fila;
        }
        mysqli_close($conexion);
        return array($productoPedido, $relacionados, $carrito1);
    }

    mysqli_close($conexion);
    return array($productoPedido, $relacionados, false);
}

function getHistorial($usuario)
{
    include 'conexion.php';

    $id = $usuario->id;

    //Crear Query
    //$sql = "SELECT venta_pedido.id_VP, venta_pedido.estado_VP,  venta_pedido.fecha_VP, venta_pedido.fechaDeEntrega_VP,  cliente.direccion_C, venta_pedido.total_VP FROM (cliente INNER JOIN venta_carrito on venta_carrito.id_C = cliente.id_C) INNER JOIN venta_pedido ON venta_pedido.id_VP = venta_carrito.id_VP WHERE venta_pedido.id_VP='{$pedidoID}'";
    $sql = "SELECT venta_pedido.id_VP, venta_pedido.estado_VP,  venta_pedido.fecha_VP, venta_pedido.fechaDeEntrega_VP, venta_pedido.total_VP,venta_pedido.tipoVenta_VP FROM (cliente INNER JOIN venta_carrito on venta_carrito.id_C = cliente.id_C) INNER JOIN venta_pedido ON venta_pedido.id_VP = venta_carrito.id_VP WHERE cliente.id_C='{$id}' ORDER BY venta_pedido.id_VP";

    //Ejecutar Query
    if (!($consulta = mysqli_query($conexion, $sql))) {
        mysqli_close($conexion);
        return array('error' => "No se pudo realizar la consulta.");
    }

    while ($fila = mysqli_fetch_assoc($consulta)) {
        $historial[] = $fila;
    }

    mysqli_close($conexion);
    return $historial;
}

///////////////////////////////////////////////////
////////////////// Miguel Bravo ///////////////////
///////////////////////////////////////////////////



/* Registrar productos */
function registrarProducto($data)
{
    include("conexion.php");
    $sql = "INSERT into producto(nombre_PR, precio_PR, inversion_PR, foto_PR, cantidad_PR, novedad_PR, discontinuo_PR, descripcion_PR, fecha_PR, unidadPeso_PR, nombreDescripcion_PR, piezasCaja_PR) VALUES 
    ('$data->nombre', '$data->precio_publico', '$data->precio_inversion', '', '$data->cantidad', '$data->novedad', '$data->disponibilidad', '$data->descripcion_pro', CURRENT_DATE(), '$data->unidadPeso_PR', '$data->descripcion_pro', '$data->piezasCaja_PR')";

    // $consulta = "SELECT MAX(id_PR) AS id_PR FROM producto";
    // $res = mysqli_query($conexion, $consulta); // or die("Error en la consulta:" . mysqli_error());
    // $id_PROD = $res; //[0]["id_PR"];

    //  insertaImagen($id_PROD, "url_imagen"); // $data->url_imagen);

    $result = mysqli_query($conexion, $sql);
    // mysqli_close($conexion);
    // return 1;
    if (isset($result)) {
        return 1;
        mysqli_close($conexion);
    } else {
        return 0;
        mysqli_close($conexion);
    }
}

/*Control para imagen de productos */
function insertaImagen($id_PR, $tipo_imagen)
{
    if (empty($_FILES[$tipo_imagen]["name"]))
        return;

    $file_name = $_FILES[$tipo_imagen]["name"];
    $extension = pathinfo($_FILES[$tipo_imagen]["name"], PATHINFO_EXTENSION);
    $ext_formatos = array('png', 'gif', 'jpg', 'jpeg', 'pdf');


    if (!in_array(strtolower($extension), $ext_formatos))
        return;


    // $dia = date("d");
    // $mes = date("m");
    // $anio = date("Y");

    $targetDir = "img/productos/";

    @rmdir($targetDir);

    if (!file_exists($targetDir)) {

        @mkdir($targetDir, 077, true);
    }

    $token = md5(uniqid(rand(), true));
    $file_name = $token . '.' . $extension;

    $add = $targetDir . $file_name;
    $db_url_img = "productos/$file_name";

    if (move_uploaded_file($_FILES[$tipo_imagen]["tmp_name"], $add)) {

        $sql = "UPDATE producto SET $tipo_imagen = '$db_url_img' WHERE id_PR = $id_PR";

        // $result = mysqli_query($conexion, $sql);


    }
}

/* Actualizaicon de cantidad de productos surtidos*/
function surtirProductos($data)
{
    include("conexion.php");

    foreach ($data as $index => $obj) {
        $sql = "UPDATE producto SET cantidad_PR=cantidad_PR + $obj->cantidad where id_PR = $obj->nombre";
        $result = mysqli_query($conexion, $sql);
        if (!isset($result)) {
            return false;
        }
    }

    return 1;
    mysqli_close($conexion);
}

function eliminarProducto($data)
{
    include("conexion.php");

    $sql = "UPDATE producto SET discontinuo_PR=1 where id_PR = $data";
    $result = mysqli_query($conexion, $sql);
    if (!isset($result)) {
        return false;
    }


    return 1;
    mysqli_close($conexion);
}

function registrarUsuarioCliente($data)
{
    include("conexion.php");

    $sql = "INSERT into cliente(correo_C, contrasena_C, telefono_C, nombre_C, apellidos_C, foto_C, fecha_C, direccion_C, colonia_C, cp_C, tipo_C, activo_C) VALUES 
    ('$data->email_ref', '$data->contrasena_ref', '$data->tel_ref', '$data->nombre_ref', '$data->apellido_ref', 'colita', CURRENT_DATE(), '$data->calle_ref', '$data->colonia_ref', '$data->cp_ref', 'Cliente', '1')";


    $result = mysqli_query($conexion, $sql);

    if (isset($result)) {
        return 1;
        mysqli_close($conexion);
    } else {
        return 0;
        mysqli_close($conexion);
    }

    mysqli_close($conexion);
}

function insertarImagen($correo, $contrasena, $telefono, $nombre, $apellido, $foto, $direccion, $colonia, $cp, $token)
{
    include("conexion.php");

    $sql = "INSERT INTO cliente ( correo_C, contrasena_C, telefono_C, nombre_C, apellidos_C, foto_C, fecha_C, direccion_C, colonia_C, cp_C, tipo_C, activo_C, token_C )
    
    VALUES ('$correo', '$contrasena', '$telefono', '$nombre', '$apellido', '$foto', CURRENT_DATE(), '$direccion', '$colonia', '$cp', 'Cliente', 1, '$token')";

    $result = mysqli_query($conexion, $sql);

    if (isset($result)) {
        return $result;
        // return 1;
        mysqli_close($conexion);
    } else {
        // return 0;
        return $result;
        mysqli_close($conexion);
    }

    //    return '{"msg":"imagen agregada"}';

    mysqli_close($conexion);
}

function conexionMiguel()
{
    define('host', 'localhost');
    define('user', 'root');
    define('pass', '');
    define('name', 'icandy');

    return new mysqli(host, user, pass, name);
}

function usuarioExiste($correo)
{

    // include("conexion.php");
    // global $conexion;

    $conexion = conexionMiguel();
    // $conexion = new mysqli(host, user, pass, name);
    //$con = $conexion;

    $stmt = $conexion->prepare("SELECT correo_C FROM cliente WHERE correo_C = ? LIMIT 1");

    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    $stmt->close();
    if ($num > 0) {
        $conexion->close();
        return true;
    } else {
        $conexion->close();
        return false;
    }
}

function hashPassword($contrasena)
{
    $hash = password_hash($contrasena, PASSWORD_BCRYPT); //PASSWORD_DEFAULT    
    return $hash;
}

function generateToken()
{
    $gen = md5(uniqid(mt_rand(), false));
    return $gen;
}

function generateToken_for_password($id_C)
{
    $con = conexionMiguel();
    $token = generateToken();
    $stmt = $con->prepare("UPDATE cliente SET token_password_C=?, password_request_C=1 WHERE id_C=?");
    $stmt->bind_param('ss', $token, $id_C);
    $stmt->execute();
    $stmt->close();
    $con->close();
    return $token;
}

function sendEmail($correo, $nombre, $asunto, $cuerpo)
{
}

function login($correo, $password)
{
    include("conexion.php");
    $con = conexionMiguel();

    $stmt = $con->prepare("SELECT id_C, tipo_C, contrasena_C, password_request_C, password_requested_C, token_C FROM cliente WHERE correo_C = ? AND activo_C = 1");

    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;
    // $stmt->close();

    //$resul = 0;
    $resul_json = null;

    if ($num > 0) { //No existe el usuario
        $stmt->bind_result($id, $id_tipo, $contrasena, $passowrd_request, $password_temp_C, $token_C);

        $stmt->fetch();

        if ($passowrd_request == 1) {
            $validarPassword = password_verify($password, $password_temp_C);
            if ($validarPassword) {
                //update requesto to 0                
                $sql = "UPDATE cliente SET password_request_C = 0 WHERE id_C = $id";

                $result = mysqli_query($conexion, $sql);
            }
        } else {
            $validarPassword = password_verify($password, $contrasena);
        }

        if ($validarPassword) {
            lastSession($id);
            $_SESSION['id_C'] = $id;
            $_SESSION['tipo_C'] = $id_tipo;
            $resul = 1;
            $resul_json = "";

            return array('id_C' => $id, 'tipo_C' => $id_tipo, 'token_C' => $token_C);
            //  mandarlo al icandy
        } else {
            $resul = 0;
            return $resul_json;
        }
    } else {
        $resul = 2;
        return $resul_json;
    }

    // return $resul_json;
}

function lastSession($id)
{


    //  $con = conexionMiguel();
    //  $con = new mysqli(host, user, pass, name);

    // $stmt = $conexion->prepare("UPDATE cliente SET last_session_C=NOW(), token_password='', password_request=1 WHERE id = ?");
    // $stmt->bind_param('s', $id);
    // $stmt->execute();
    // $stmt->close();
}

function getValores($campo, $campoCondicion, $valor) //id_C, correo_C, $correo (algo@gmail.com)
{
    $conexion = conexionMiguel();

    $stmt = $conexion->prepare("SELECT $campo FROM cliente WHERE $campoCondicion = ? LIMIT 1");
    $stmt->bind_param('s', $valor);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;

    if ($num > 0) {
        $stmt->bind_result($campo_returned);
        $stmt->fetch();
        $conexion->close();
        return $campo_returned;
    } else {
    }
}


function enviarCorreo($email, $asunto, $cuerpo)
{
    //Load Composer's autoloader
    require 'vendora/autoload.php';

    $result_email = 0;

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings    
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication       
        $mail->Username   = 'iCandy.mx@gmail.com';                     //SMTP username
        $mail->Password   = 'Proyectoicandy';                               //SMTP password
        $mail->SMTPSecure =  'tls'; //PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       =  587; //465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('iCandy.mx@gmail.com', 'iCandy');
        $mail->addAddress($email, '');     //Add a recipient
        //Name is optional   

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        //  echo 'Message has been sent';
        $result_email = 1;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $result_email = 0;
    }
    return $result_email;
}

function generateTemporalPassword($length)
{
    $key = "";
    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
    //$pattern = "1234567890abcdefghijklmñnopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ.-_*/=[]{}#@|~¬&()?¿";
    $max = strlen($pattern) - 1;
    for ($i = 0; $i < $length; $i++) {
        $key .= substr($pattern, mt_rand(0, $max), 1);
    }
    return $key;
}

function getDataUsuario($id)
{
    $con = conexionMiguel();

    $la_new = (int)$id;
    // $stmt = $con->prepare("SELECT nombre_C, apellido_C, correo_C, telefono_C, direccion_C, colonia_C, cp_C FROM cliente WHERE id_C = ?");
    $stmt = $con->prepare("SELECT nombre_C, apellidos_C, correo_c, telefono_C, direccion_C, colonia_C, cp_C, foto_C FROM cliente WHERE id_C = ?");
    $stmt->bind_param("i", $la_new);
    $stmt->execute();
    $stmt->store_result();
    $num = $stmt->num_rows;

    $resul_json = null;

    if ($num > 0) {
        // $stmt->bind_result($nombre_C, $apellido_C, $correo_C, $telefono_C, $direccion_C, $colonia_C, $cp_C);
        $stmt->bind_result($nombre_C, $apellidos_C, $correo_C, $telefono_C, $direccion_C, $colonia_C, $cp_C, $foto_C);
        $stmt->fetch();

        // return array('nombre_C' => $nombre_C, 'apellido_C' => $apellido_C, 'correo_C' => $correo_C, 'telefono_C' => $telefono_C, 'direccion_C' => $direccion_C, 'colonia_C' => $colonia_C, 'cp_C' => $cp_C);
        // return array('nombre_C' => $nombre_C, 'apellidos_C' => $apellidos_C);        
        // return array('nombre_C'=>$nombre_C, 'apellidos_C'=>$apellidos_C);             
        return array('nombre_C' => $nombre_C, 'apellidos_C' => $apellidos_C, 'correo_C' => $correo_C, 'telefono_C' => $telefono_C, 'direccion_C' => $direccion_C, 'colonia_C' => $colonia_C, 'cp_C' => $cp_C, 'foto_C' => $foto_C);
    } else {
        return $resul_json;
    }
}

function updatePerfilCliente($nombre, $apellido, $direccion, $colonia, $cp, $correo, $telefono, $id)
{
    include("conexion.php");

    $sql = "UPDATE cliente SET nombre_C = '{$nombre}', apellidos_C = '{$apellido}',  direccion_C = '{$direccion}', colonia_C = '{$colonia}', cp_C = '{$cp}', correo_C = '{$correo}', telefono_C = '{$telefono}' WHERE id_C = '{$id}'";

    // $sql = "UPDATE cliente SET nombre_C = '{$nombre}' WHERE id_C = '{$id}'";

    $result = mysqli_query($conexion, $sql);

    if (isset($result)) {
        return $result;
        // return 1;
        mysqli_close($conexion);
    } else {
        // return 0;
        return $result;
        mysqli_close($conexion);
    }

    //    return '{"msg":"imagen agregada"}';

    mysqli_close($conexion);
}

function updateClientePasswor($id, $password)
{
    include("conexion.php");

    $pass_hash = hashPassword($password);

    $sql = "UPDATE cliente SET contrasena_C = '{$pass_hash}' WHERE id_C = '{$id}'";

    $result = mysqli_query($conexion, $sql);

    if (isset($result)) {
        return $result;
        // return 1;
        mysqli_close($conexion);
    } else {
        // return 0;
        return $result;
        mysqli_close($conexion);
    }

    //    return '{"msg":"imagen agregada"}';

    mysqli_close($conexion);
}


function updateProductos($data)
{
    include("conexion.php");

    // '$data->nombre', '$data->precio_publico', '$data->precio_inversion', '', '$data->cantidad', '$data->novedad', '$data->disponibilidad', '$data->descripcion_pro', CURRENT_DATE(), '$data->unidadPeso_PR', '$data->descripcion_pro', '$data->piezasCaja_PR'";

    // $sql = "UPDATE producto SET nombre_PR= '{$data->nombre}' inversion_PR = '{$data->precio_inversion}', cantidad_PR = '{$data->cantidad}', precio_PR = '{$data->precio_publico}', unidadPeso_PR = '{$data->unidadPeso_PR}', piezasCaja_PR = '{$data->piezasCaja_PR}', descripcion_PR = '{$data->descripcion_pro}'  WHERE id_PR = 1";
    // $sql = "UPDATE producto SET nombre_PR= '{$data->nombre}', inversion_PR = '{$data->precio_inversion}', cantidad_PR = '{$data->cantidad}', precio_PR = '{$data->precio_publico}', unidadPeso_PR = '{$data->unidadPeso_PR}', piezasCaja_PR = '{$data->piezasCaja_PR}', descripcion_PR = '{$data->descripcion_pro}'  WHERE id_PR = 1";


    $sql = "UPDATE producto SET nombre_PR= '{$data->nombre}', inversion_PR = '{$data->precio_inversion}', cantidad_PR = '{$data->cantidad}', precio_PR = '{$data->precio_publico}', unidadPeso_PR = '{$data->unidadPeso_PR}', piezasCaja_PR = '{$data->piezasCaja_PR}', descripcion_PR = '{$data->descripcion_pro}'  WHERE id_PR = '{$data->id_PR}'";

    $result = mysqli_query($conexion, $sql);
    if (isset($result)) {
        return 1;
        mysqli_close($conexion);
    } else {
        return 0;
        mysqli_close($conexion);
    }
}
