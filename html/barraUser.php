<?php
session_start();
$rutaImagen = "../img/usuarios/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/carrito.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="../controller/carrito.js"></script>
    <title>Proyecto</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-primary bg-primary">
        <div class="container">
          <a class="navbar-brand" href="../html/homeUser.php">Inicio</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link active" href="../vistas/perfil.php">Perfil
                  <span class="visually-hidden">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../html/login.php">Sesion</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../html/about.php">About</a>
              </li>
            </ul>
        </div>
        <div class="container-icon">
				<div class="container-cart-icon" onclick=" location.href='../vistas/carrito.php';">
					<svg
						xmlns="http://www.w3.org/2000/svg"
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						class="icon-cart"
					>
						<path
							stroke-linecap="round"
							stroke-linejoin="round"
							d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
						/>
					</svg>
					<div class="count-products">
						<span id="contador-productos">0</span>
					</div>
				</div>
				<div class="container-cart-products hidden-cart">
					<div class="row-product hidden">
						<div class="cart-product" >
							<svg
								xmlns="http://www.w3.org/2000/svg"
								fill="none"
								viewBox="0 0 24 24"
								stroke-width="1.5"
								stroke="currentColor"
								class="icon-close"
							>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									d="M6 18L18 6M6 6l12 12"
								/>
							</svg>
						</div>
					</div>
					<div class="cart-total hidden">
						<h3>Total:</h3>
						<span class="total-pagar">$200</span>
					</div>
					<p class="cart-empty">El carrito está vacío</p>
				</div>
			</div>
      <div>
        <img id="miniFoto" src="<?echo $rutaImagen;if($_SESSION['Foto']!==""){echo $_SESSION["Foto"];}else{echo "user.png";}echo "?".rand()%10000 ?>" width = "35 px" alt="imagen"/>
        <span id="miniNombre"><?=$_SESSION['nombUsuario'];?></span>
        </div>
    </div>
</nav>