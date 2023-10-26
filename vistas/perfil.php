<?php
include "../html/barraUser.php";
include "../php/classUsers.php";
$oUsers=new Users();
if(isset($_REQUEST["accion"])){
    echo $oUsers->ejecuta($_REQUEST['accion']);
}else{
    echo $oUsers->ejecuta("viewProfile");
}
echo '<div Style=text-align:center;>';
echo "Hola  desde usuarios";
echo "<br>";
?>
</div>