<?
session_start();
include "classBaseDeDatos.php";
include "../php/class.phpmailer.php";
include "../php/class.smtp.php";
      $contra;
      $cadena="ABCDEFGHIJKLMNPQRSTUVWXYZ123456789123456789";
      $numeC=strlen($cadena);
      $nuevPWD="";
      for ($i=0; $i<8; $i++)
      $nuevPWD.=$cadena[rand()%$numeC];

      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->Host="smtp.gmail.com"; //mail.google
      $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
      $mail->Port = 465;     // set the SMTP port for the GMAIL server
      $mail->SMTPDebug  = 1;  // enables SMTP debug information (for testing)
                              // 1 = errors and messages
                              // 2 = messages only
      $mail->SMTPAuth = true;   //enable SMTP authentication
    
      $mail->Username =   "paulapalma38@gmail.com"; // SMTP account username
      $mail->Password = "wmrhypgihjkfxipy";  // SMTP account password   cjrulnctaphbokur
      
      $mail->From="Empresa";
      $mail->FromName="";
      $mail->Subject = "Registro completo";
      $mail->Msghtml("<h1>BIENVENIDO ".$_POST['nombres']." ".$_POST['apellidos']."</h1><h2> tu clave de acceso es : ".$nuevPWD."</h2>");
      $mail->AddAddress($_POST['correo']);
      $mail->AddAddress("admin@admin.com");
      if (!$mail->Send()) {
          echo  "Error: " . $mail->ErrorInfo;
      }else { 
            $oBD = new baseDatos();
            if($_POST["accion"]== "Register"){
                  if($_POST['capchat'] == $_SESSION['captcha']){
                        $cad="INSERT INTO usuario set Nombre='".$_POST['nombres']."', Apellido='".$_POST['apellidos']."',
                         Email='".$_POST['correo']."', Pwd=PASSWORD('".$nuevPWD."'), id_Rol = 2, Fecha_ulti_acceso='".date("Y-m-d")."', Accesos = 0, Genero='".(($_POST['Genero']=="F")?"Femenino":"Masculino")."'";
                         $oBD->m_query($cad);
                        $_SESSION['correo'] = $_POST['correo'];
                        if($oBD->a_error)
                              header("location: ../html/login.php?e=7");
                        else
                              header("location: ../html/login.php?e=3");
                  }else{
                        header("location: ../html/register.php?e=1");
                  }
            }else{
                  if($_POST['capchat'] == $_SESSION['captcha']){
                        $cad="UPDATE usuario set Pwd= password('".$nuevPWD."') where Email='".$_POST['correo']."'";
                        $oBD->m_query($cad);
                        $_SESSION['correo'] = $_POST['correo'];
                        if($oBD->a_error)
                              header("location: ../html/login.php?e=11");
                        else
                              header("location: ../html/login.php?e=12");
                        $_SESSION['correo'] = $_POST['correo'];
                  }else{
                        header("location: ../html/password.php?e=70");
                  }
            }
      }
?>