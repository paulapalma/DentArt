
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/jquery-confirm.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="../js/jquery-confirm.js"></script>
    <script src="../controller/carrito.js"></script>
    <title>Proyecto</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-primary bg-primary">
        <div class="container-fluid">
          <a class="navbar-brand" href="../html/homeVend.php">Inicio</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link active" href="../vistas/productos.php">Productos
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
        <div>
        <img src="../img/hacker.png" width = "35 px" alt="imagen"/>
        <?=$_SESSION['nombUsuario'];?>
        </div>
    </div>
</nav>