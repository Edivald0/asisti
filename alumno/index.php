<?php
//alumno /index.php
session_start();
if (isset($_SESSION["estado"])&&$_SESSION["estado"]==0) {
 include "cambiar_password.php";
}
else if (isset($_SESSION["estado"])&& $_SESSION["estado"]==1) {
		//incluir un archivo de funciones
		include "../funciones.php";
	//funciones nombre_foto(parametro) esta funcion hace hace una cosulta a la bd
	//y retornar el campo de la foto dde la tabla de los alumnos donde la matricula sea
	//igual a la de session actual.
	$foto = nombre_foto($_SESSION["usuario"]);

	?>


<h2>Bienvenido<strong><?php echo $_SESSION["nombre"];?></strong></h2>
<img src="../img/<?php echo $foto;  ?> " width="256" height="256" />
<p><a href="?op=foto">Foto</a></p>
<p><a href="?op=pass">Password</a></p>
<p><a href="?op=asis">Asistencia</a></p>
<p><a href="../salir.php">Salir</a></p>

<?php
	//formulario para cambiar la foto del susuario
	if (isset($_GET["op"])&& $_GET["op"]=="foto") {
			echo "<form action='subir_foto.php' enctype='multipart/form-data' method='post'>
	       <p><input type='file' name='foto'></p>
       <p><input type='submit' value='Subir'/></p>
       </form>";
	}
	//si el alumno quiere cambiar su pasword o es la primera vez 
	if (isset($_GET["op"])&& $_GET["op"]=="pass") {
		include'cambiar_password.php';
	}
	//mustra la asinatura que que tiene el alumno en este momento(dia y hora)
	//tiene 30 minutos de tolerancia para registrar su asistencia 
	//de lo contrario se manda un mensaje el cual dice :
	//"No hay clase en este momento, o tu tolerancia a terminado"
	if (!isset($_GET["op"])|| $_GET["op"]=="asis") {
		//se llama a la funcion mostrarAsignaturaDia con el parametro de la 
		//matricula del usuario actual y nos regresa la materia o un mensaje
		echo mostrarAsignaturaDia($_SESSION["usuario"]);

		echo "<a href=\"?op=asis&reporte=si\">REPORTES</a>";
	} 

	
	if (isset($_GET["reporte"]) && $_GET["reporte"] == "si") {
		include "reportes.php";
	}

}
?>
