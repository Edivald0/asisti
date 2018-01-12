<?php
include "../conexion.php";
session_start();
$alumno = $_SESSION["usuario"];
$materia = $_GET["materia"];
$docente = $_GET["docente"];
//NOW funcion de MYSQL que te da la fecha y hora
$consulta = " INSERT INTO asistencias VALUES('$alumno', '$materia', '$docente', NOW(), NOW()) ";
if (mysqli_query( $conexion, $consulta )) {
	header("Location: index.php?op=1");
	
}
else{
	header("Location: index.php?error=2");
}
?>
 