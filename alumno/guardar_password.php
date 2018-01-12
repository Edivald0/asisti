<?php
$anterior_pwd="";
$nuevo_pwd="";

if (isset($_POST["anterior_pwd"])) {
	$anterior_pwd=$_POST["anterior_pwd"];
}
if (isset($_POST["nuevo_pwd"])) {
	$nuevo_pwd=$_POST["nuevo_pwd"];
}
if (empty($nuevo_pwd)|| empty($anterior_pwd)) {
	header("Location:index.php?error=1");	
}
else{
	include"../conexion.php";
	session_start();
	$consulta="UPDATE alumnos SET password=md5('$nuevo_pwd'),";
	$consulta .="estado = 1 WHERE matricula='".$_SESSION["usuario"]."'";
	$consulta .=" AND password=md5('$anterior_pwd')";
	//echo "$consulta";
	//exit();

	mysqli_query($conexion,$consulta) or die (mysqli_error($conexion));
	if (mysqli_affected_rows($conexion)==1) {
		session_destroy();
		echo "<p>Tu password se cambio de forma correcta.</p>";
		echo "<p><a href='../index.php'>Ir a inicio<a/></p>";

	}
	else{
		header("Location:index.php?error=2");
	}
}
?>