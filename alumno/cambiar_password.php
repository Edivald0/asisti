<?php
//alumno/cambiar _password.php
echo "<p>Bienvenido alumno: <strong>".$_SESSION["nombre"];
echo "</strong></p>";

?>
   <h3>Tienes que cambiar tu password</h3>
   <form action="guardar_password.php" method="post" >
  
  <p>Anterior password: <input type="password" name="anterior_pwd" /></p>
  <p>Nuevo Password: <input type="password" name="nuevo_pwd" /> </p>
  <input type="submit" name="btn_ingresar" value="Guardar" />
</form>
