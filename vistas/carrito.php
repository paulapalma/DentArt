<?php
session_start();
if($_SESSION['admin']){
    include "../html/barraAdmin.php";
}else{
    include "../html/barraUser.php";
}
include "../php/classCarrito.php";
echo "<div id='principal' class='container-fluid'>";
if(isset($_REQUEST['accion'])){
    echo $oCarrito->ejecuta($_REQUEST['accion']);
}else{
    echo $oCarrito->ejecuta("list");
}

echo "</div>";
echo '<div Style=text-align:center>';
echo "Hola  desde Carrito";
echo "<br>";
?>
</div>