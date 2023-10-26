<?php
session_start();  
include "../php/funciones.php";
$cadena=captcha();
include "../html/barra.php";
if(isset($_GET['e'])){
  if($_GET['e'] == '12')
  echo "SU NUEVA CONTRASEÑA SE HA ENVIADO A SU CORREO EXITOSAMENTE";
}
if(isset($_GET['e'])){
  if($_GET['e'] == '72')
  echo "NO SE INTRODUJO EMAIL";
}
if(isset($_GET['e'])){
  echo '<div class="conntainer">
    <div class="alert alert-danger" role="alert">
    <div class="col-4">';
  switch($_GET['e']){
    case '70':
      echo "EL CAPTCHA INTRODUCIDO ES INCORRECTO. INTENTE NUEVAMENTE";
      break;
    case '71':
      echo "NO SE INTRODUJO EL CAPTCHA";
      break;
  }
    echo'</div></div></div>';
}
?>
  <form action="../php/registrarse.php" method="POST">
  <section class="form-recuperar">
    <h4>Recuperar contraseña</h4>
    <input class="controls" type="email" name="correo" id="correo" placeholder="Ingrese su Correo" REQUIRED>
    <input class="controls" type="text" name="capchat" id="capchat" placeholder="<?=$cadena;?>" required>
    <input type="hidden" name="accion" value = "Recuperar"/>
    <input class="botons" type="submit" value="Recuperar">
  </section>
</form>
</body>
</html>
