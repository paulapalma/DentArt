  <?php
  session_start();
  include "../php/funciones.php";
  $cadena=captcha();
  include "../html/barra.php";
  if(isset($_GET['e'])) {
    echo '<div class="conntainer">
    <div class="alert alert-danger" role="alert">
    <div class="col-4">';
    if($_GET['e']==1){
      echo 'captcha incorrecto';
    }
    echo'</div></div></div>';
  }
  ?>
  <section class="form-register">
    <form action="../php/registrarse.php" method="POST">
      <h4>Registro</h4>
    <input class="controls" type="text" name="nombres" id="nombres" placeholder="Ingrese su Nombre" required/>
    <input class="controls" type="text" name="apellidos" id="apellidos" placeholder="Ingrese su Apellido" required/>
    <input class="controls" type="email" name="correo" id="correo" placeholder="Ingrese su Correo" required/>
    <input class="controls" type="text" name="capchat" id="capchat" placeholder="<?=$cadena;?>" required/>
    <fieldset class="form-group"> 
      <legend class="mt-4">Género</legend>
      <div class="row">
     <div class="col-4">
      <div class="form-check form-switch">
        <input class="form-check-input" type="radio" id="Fem" value="F" name="Género">
        <label class="form-check-label" for="Fem">Femenino</label>
      </div>
    </div>
    <div class="col-4">
      <div class="form-check form-switch">
        <input class="form-check-input" type="radio" value="M" id="masc" name="Género">
        <label class="form-check-label" for="masc">Masculino</label>
      </div>
    </div>
    <div class="col-4">
      <div class="form-check form-switch">
        <input class="form-check-input" type="radio" value="O" id="otro" name="Género">
        <label class="form-check-label" for="otro">Otro</label>
      </div>
    </div>
    </div>
    </fieldset>
    <input type="hidden" name="accion" value = "Register"/>
    <p>Estoy de acuerdo con los <a href="#">terminos y condiciones</a></p>
    <input class="botons" type="submit" value="Registrar">
    </form>
  </section>
</body>
</html>