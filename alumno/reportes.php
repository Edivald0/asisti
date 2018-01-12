<h2>Materias</h2>
<br/>

<?php echo mostraAsignatura($_SESSION["usuario"]); ?>

<?php
if( isset($_GET["reporte"])&& isset($_GET["grupo"]) && isset($_GET["materia"])){
	$grupo = $_GET["grupo"];
	$materia = $_GET["materia"];
	echo "<h2> GRAFICA<h/2>";
	echo "<img src='grafica.php?grupo=$grupo&materia=$materia' alt='grafica' width=\"400\"/>";
}
else{
	echo"<h2> GRAFICA</h2>";
	echo "<p class=\"error\">Tienes que seleccionar una materia.</p>";
}
?> 

