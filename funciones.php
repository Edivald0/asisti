<?php
/**
* Funciones para realizar una consulta a la base de datos y obtener el
*nombre de la foto del usuario activo
*/
function nombre_foto($matri) {

	include"conexion.php";
	$consulta="SELECT * FROM alumnos WHERE matricula = '$matri'";
	$resultado=mysqli_query($conexion, $consulta);
	$registro=mysqli_fetch_assoc($resultado);
	$foto = $registro["foto"];
	return $foto;
}
/** El parametro de $esxtencion determinara que tipo de imagen no se borrará
*   por ejemplo si es jpg significa que la imagen con extensión .jpg se
*   queda en el servidor y si existen imagenes con el mismo nombre pero con 
*   extensión .png o .gif se eliminara, con esta funcion evito tener 
*   tener imagenes duplicadas con distintas extensiones pra cada perfil la
*   funcion file_exists evalua si un archivo existe y la funcion unlike
*   borra un archivo del servidor.
*/
function borrar_imagenes($ruta, $extension){
		switch ($extension) {
			case ".jpg":
				if (file_exists($ruta.".png")) 
						unlink($ruta."png");
				if (file_exists($ruta.".gif")) 
						unlink($ruta."gif");
				break;

			case ".gif":
				if (file_exists($ruta.".png")) 
						unlink($ruta."png");
				if (file_exists($ruta.".jpg")) 
						unlink($ruta."jpg");
				break;
			case ".png":
				if (file_exists($ruta.".jpg")) 
						unlink($ruta."jpg");
				if (file_exists($ruta.".gif")) 
						unlink($ruta."gif");
				break;
			
		}
}

function mostrarAsignaturaDia($matri){
	include "conexion.php";

	$consulta= "SELECT m.nombre, h.lun, h.mar, h.mie, h.jue, h.vie, h.sab, h.dom, m.clave, h.docente "
			  . " FROM alumnos a, materias m, alumno_materia am, horarios h WHERE "
			  . " am.alumno = a.matricula AND h.materia = am.materia AND "
			  . " m.clave = am.materia AND a.matricula = '$matri' ";
	$resultado = mysqli_query($conexion, $consulta);
	$mensaje ="<div class=\"asistencia\">"
				."<h2>Registrar Asistencia </h2> </br>";

	if (mysqli_num_rows($resultado)>0) {
		//la funcion date retorna segun el atributo el dia o la  hora
		//en este caso w retorna el dia de las semanas en entero comenzando
		//por el lunes 1 hasta el domingo 7
		$hoy= date("w");

		//en este caso date retorna la hora en formato de 23 horas
		$horaActual=date("H:i:s");
		
		while ($registro = mysqli_fetch_array($resultado)) {
			$dia = date("Y-m-j");
			$claseHoy = yaregistroAsistencia($matri, $registro[8], $dia);
			//si materia el dia de hoy no esta vacio, indica que tiene clase
			if (empty($claseHoy)) {
				# code...
			
				if (!empty($registro[$hoy])) {
					//las siguientes tres lineas es para calcular los 30 minutos  de tolerancia 
					//que tiene el alumno para registrar su asistencia
					$horaClase = date($registro[$hoy]);
					$tolerancia = strtotime('+31 minute',strtotime($horaClase));
					$tolerancia = date('H:i:s',$tolerancia);
					//si la horaActual esta en el rango de los 30 minutos de tolerancia
					//mandamos el mensaje con la materia y su clalve para hacer
					//el registro correspondiente

					if ($horaActual >=$horaClase && $horaActual <= $tolerancia) {
						$claseHoy = "<p>Materia: <strong>".$registro[0] . "</strong>"
								   . "<br/> Docente:<strong>" . darNombreDocente($registro[9])."</strong>"
								   . "<br/> Fecha:<em>". fechaHoraMexico(date("Y-m-j G:i:s")). "</em>"
								   ."<br/><a class='boton' href='registrar_asistencia.php?materia="
								   . $registro[8] . "&docente=" .$registro[9]. "'>Registrar Asistecia </a></p>";
					}

				}
			}
		}
		//si la variable claseHoy esta vacia, es porque no hay clase hoy o en este momento.
		if (empty($claseHoy)) {
			$mensaje .="<p class=\"error\">No hay clase en este moemento,"
					 ."<br>o tu tolerancia se ha terminado.</p>";
		}
		else{
			$mensaje .=$claseHoy;
		}
	}else{
		$mensaje.="<p class=\error\"> No hay clase para este dia.</p>";
	}
	$mensaje.="</div>";
	return $mensaje;
}

function fechaHoraMexico($timestamp){
	date_default_timezone_set('UTC'); 
	date_default_timezone_set("America/Mexico_City");
	$hora = strftime("%I:%M:%S %p", strtotime($timestamp) );
	setlocale(LC_TIME, 'spanish');
	$fecha = utf8_encode(strftime("%A %d de %B del %Y", strtotime($timestamp)));
	return $fecha . " " . $hora;	
}

//funcion para obtener el nombre del docente

function darNombreDocente($clave){
	include "conexion.php";
	$consulta = " SELECT nombre FROM docentes WHERE clave = '$clave' ";
	$resultado = mysqli_query($conexion,$consulta);
	$registro = mysqli_fetch_assoc($resultado);

	return $registro["nombre"];
}	
function darNombreMateria($clave){
	include "conexion.php";
	$consulta = " SELECT nombre FROM materias WHERE clave = '$clave' ";
	$resultado = mysqli_query($conexion,$consulta);
	$registro = mysqli_fetch_assoc($resultado);

	return $registro["nombre"];
}
//funcion para obtener si ya registro asistenciaa

function yaregistroAsistencia($matricula,$materia,$dia){
   include "conexion.php";
  $consulta=" SELECT * FROM asistencias WHERE alumno = '$matricula' AND dia = '$dia' AND materia = '$materia'";
  $resultado= mysqli_query($conexion, $consulta);

   $mensaje="";
   if (mysqli_num_rows($resultado) > 0) {
   	 $registro = mysqli_fetch_assoc($resultado);
   	 $dia = $registro["dia"];
   	 $hora = $registro["hora"];
   	 $materia = darNombreMateria($registro["materia"]);
   	 $mensaje = "<p class=\" correcto\">Ya tienes asistencias a:"
   	 			."<br />Materia: $materia"
   	 			."<br />". fechaHoraMexico(date($dia."".$hora));
   	# code...
   }
   return $mensaje;
}

function mostraAsignatura($matri){
 	include "conexion.php";
 	$consulta = " SELECT m.clave, m.nombre, h.docente, h.grupo "
 				." FROM alumnos a, materias m, alumno_materia am, horarios h "
 				." WHERE am.alumno = a.matricula "
 				." AND h.materia = am.materia "
 				." AND m.clave = am.materia "
 				." AND a.matricula = '$matri' ";
 	$resultado= mysqli_query($conexion, $consulta);
 	$mensaje = "";
 	if (mysqli_num_rows($resultado) > 0) {
 		$mensaje = "<ol>";
 		while ($registro = mysqli_fetch_assoc($resultado)) {
 			$mensaje .= "<li> <a href='?op=asis&reporte=si&grupo="
 					 . $registro["grupo"]. "&materia=". $registro["clave"]
 					 . "'>".$registro["nombre"] ."</a></li>";
 		}
 		$mensaje .="</ol>";
 	}else{
 		$mensaje = "<p> No tienes materias registradas.</p>";
 	}
 	return $mensaje;
 	mysqli_close($conexion);
}
?>