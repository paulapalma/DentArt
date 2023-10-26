<?php
session_start();

include "../php/classBaseDeDatos.php";
$oDB = new baseDatos();
$cad = "SELECT * FROM usuario WHERE Email='".$_POST['email']."' AND Pwd = password('".$_POST['pwd']."');";
//echo $cad;
//exit();
//$_POST['pwd']=str_replace("'","",$_POST['pwd']);
$_POST['email']=str_replace("'","",$_POST['email']);

$datosUsuario = $oDB -> m_obtenerRegistro($cad);
//print_r($oDB->a_numRegistros);
//exit();
if($oDB->a_numRegistros == '1' ){
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['nombUsuario'] = $datosUsuario['Nombre'].' '. $datosUsuario['Apellido'];
    $_SESSION['id_Usuario'] = $datosUsuario['id_Usuario'];
    $_SESSION['Foto'] = $datosUsuario['Foto'];
    $cad = "UPDATE usuario SET fecha_ulti_acceso='".date("Y-m-d")."',Accesos=Accesos+1 WHERE Email='".$_POST['email']."'";
    if($datosUsuario['id_Rol'] == 1){
        $_SESSION['admin']=true;
        header("location: ../html/index.php?");
    }else{
        if($datosUsuario['id_Rol'] == '3'){
            header("location: ../html/homeVend.php"); 
        }else{
            header("location: ../html/homeUser.php");
        }
    }
}else{
    header("location: ../html/login.php?e=1");
}
?>