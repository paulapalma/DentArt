<?php
include "../html/barraAdmin.php";
include "../php/classUsers.php";
if(isset($_REQUEST['accion'])){
    echo $oUsers->ejecuta($_REQUEST["accion"]);
}else{
    echo $oUsers->ejecuta("list");
}
echo '<div Style=text-align:center;>';
echo "Hola  desde usuarios";
echo "<br>";
$oUsers=new Users();
?>
</div>