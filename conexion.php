<?php
$servername = "localhost";
$username = "root";
$password = "";
$baseDatos = "bdasistencias";

//crear coneccion
$conexion = mysqli_connect($servername, $username, $password, $baseDatos);
//checar coneccion
if (!$conexion) {
	die("coneccion fallida:". mysqli_connect_error());
}

	mysqli_set_charset($conexion, "utf8");
//echo "coneccion exitosa";
?>