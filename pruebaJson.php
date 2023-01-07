<?php
$lista = '{"productos":
                    [
                    {"id_PR":"12",
                        "nombre_PR":"Pica gomas",
                        "precio_PR":"64",
                        "inversion_PR":"60",
                        "foto_PR":"https://m.media-amazon.com/images/I/712QhuoIjOL._AC_SX385_.jpg",
                        "cantidad_PR":"15",
                        "novedad_PR":"0",
                        "discontinuo_PR":"0",
                        "descripcion_PR":"Gomita sabor fresa cubierta de dulce picosito.",
                        "fecha_PR":"2022-03-13",
                        "unidadPeso_PR":"Caja",
                        "nombreDescripcion_PR":"600 g",
                        "piezasCaja_PR":"100",
                        "unidades":2,
                        "total":128},
                    {"id_PR":"13",
                        "nombre_PR":"Rockaleta",
                        "precio_PR":"57",
                        "inversion_PR":"52",
                        "foto_PR":"https://m.media-amazon.com/images/I/61kXNBHWjjL._AC_SX679_.jpg",
                        "cantidad_PR":"15",
                        "novedad_PR":"0",
                        "discontinuo_PR":"0",
                        "descripcion_PR":"Es una original paleta con múltiples capas de distintos sabores dulces y picantes, que conforme las comes van descubriendo en el centro de la paleta una deliciosa goma de mascar.",
                        "fecha_PR":"2022-03-13",
                        "unidadPeso_PR":"Caja",
                        "nombreDescripcion_PR":"480 g",
                        "piezasCaja_PR":"20",
                        "unidades":2,
                        "total":114}],
            "totalCompra":242}';
$indece;
$lista = json_decode($lista);
$cont = 0;
//print_r($lista->productos[0]->);
foreach ($lista->productos as $index => $objecto) {
    $cont++;
    foreach ($objecto as  $index2 => $valor2) {
        echo ($index2);
        echo (" ");
        echo ($valor2);
        echo nl2br("\n");
        //echo($index);
    }
    echo ($cont);
}
            
           // print_r($lista);
