<?php
session_start();
session_destroy();  
  include "../html/barra.php";
  if(isset($_GET['e'])) {
    echo '<div class="conntainer">
    <div class="alert alert-danger" role="alert">
    <div class="col-4">';
    switch($_GET['e']){
      case 1: 
        echo 'Usuario o Contraseña Incorrecta';
      break;
      case 100:
        echo 'No se ha iniciado sesión';
      break;
      case 3:
      echo 'Tu correo fue registrado con éxito ;v 
            <br/>
            La contraseña fue enviada a tu correo';
      break;
      case 12:
      echo 'Tu contraseña fue cambiada con éxito ;v 
            <br/>
            La contraseña fue enviada a tu correo';
      break;
    }
    echo'</div></div></div>';
  }
  echo '<section class="form-login">
  <form action="../php/validator.php" method="POST">
      <h5>Iniciar Sesión</h5>
      <input class="controls" type="text" name="email" value="'.((isset($_GET['e'])=='3')? $_SESSION['correo']:"").'" placeholder="correo" required>
      <input class="controls" type="password" name="pwd" value="" placeholder="Contraseña" required>
      <input class="buttons" type="submit" name="" value="Ingresar">
      </form>
      <p><a href="../html/password.php">¿Olvidaste tu Contraseña?</a><br></br>
    </section>
</body>
</html>';
?>