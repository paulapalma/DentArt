<?php
session_start();
include "../php/classCarrito.php";
include "barraUser.php";
$oDB = new BaseDatos();
?>
<div id='principal' class='container-fluid'></div>
<div class="container-items">
<?
	$oDB->m_query('SELECT * from productos;');
	//$prueba=$oDB->m_crearLista("productos", "id", "Nombre", "Nombre");
	for($i = 0; $i < $oDB->a_numRegistros; $i++){
		$tupla = $oDB->m_recuRegistro();
		//print_r($tupla);?>
		<div class="item">
				<figure>
					<img src="../img/productos/<?=$tupla['url_imagen']?>" alt="producto"/>
				</figure>
				<div class="info-product">
				<h2><?= $tupla['nombre'] ?></h2>
					<p class="price">$<?= $tupla['precio'] ?></p>
			<form method="post">
            <input type="hidden" name="accion" value = "insert"/>
			<input type="hidden" name="id" value ="<?= $tupla['id'] ?>"/>
			<input type="hidden" name="id_Usuario" value ="<?=$_SESSION['id_Usuario'] ?>"/>
            <input type="hidden" name="cantidad" value ="1"/>
            <input id="btn-add-cart" class="btn-add-cart" type="image" width="35px" src="../img/carrito-de-compra-anadir.png" />
            </form>
				</div>
			</div>
	<?}
	if(isset($_REQUEST['accion'])){
    echo $oCarrito->ejecuta($_REQUEST['accion']);
}else{
} 
	?>
</div>
<script src="../controller/carrito.js"></script>