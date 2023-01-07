<?php
    define('DB_HOST','localhost');
	define('DB_USER','root');
	define('DB_PASS','');
	define('DB_NAME','icandy');

    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if(mysqli_connect_errno()){
		echo "Falló al conectar con MySQL: " . mysqli_connect_error();
		die();
	}

?>