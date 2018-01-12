

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>ASIST - Sistema de Asisitencias</title>
</head>
<body>
	<h1>SISTEMA DE ASISTENCIAS</h1>
	<h2>Inicio de sesión</h2>
	<?php

if( isset($_GET["error"])){
	if($_GET["error"]==1)
 		echo "<p>no ingresaron (Matricula o password)</p>";
      if($_GET["error"]==2)
      	echo "<p>Los datos son incorrectos o no está registrado el alumno</p>";
      
    }
?>
	<form action="usuario_inicio.php" method="post">
		<p>Usuario: <input type="text" name="txt_usuario"/></p>
		<p>Password:<input type="password" name="pwd_usuario"/></p>
		<p><input type="submit" value="Entrada"/></p>
	</form>
</body>
</html>