<?php
$usuario="";
$pass="";
if (isset($_POST["txt_usuario"])) {
	$usuario = $_POST["txt_usuario"];
}
if (isset($_POST["pwd_usuario"])) {
	$pass= $_POST["pwd_usuario"];
}
if (empty($usuario)|| empty($pass)) {
	header("Location:index.php?error=1");
}
else{
	include"conexion.php";
	$consulta="SELECT * FROM alumnos WHERE matricula = '$usuario'";
	$consulta=$consulta."AND password = md5('$pass')";
	$resultado= mysqli_query($conexion, $consulta) or die (mysqli_error($conexion));
	if (mysqli_num_rows($resultado)==1) {
		$registro = mysqli_fetch_assoc($resultado);
		session_start();
		$_SESSION["estado"] = $registro["estado"];
		$_SESSION["usuario"] = $registro["matricula"];
		$_SESSION["nombre"] = $registro["nombre"];
		header("Location:alumno/");
	}
	else{
		header("Location:index.php?error=2");
	}
}

?>
