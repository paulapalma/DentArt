<?php
session_start();
if(isset($_SESSION['admin'])){
    include "../html/barraAdmin.php";
}else{
    include "../html/barraVend.php";
}
include "../php/classProductos.php";
if(isset($_REQUEST['accion'])){
    echo $oProductos->ejecuta($_REQUEST['accion']);
}else{
    echo $oProductos->ejecuta("list");
}
?>