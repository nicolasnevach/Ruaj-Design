<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Calcular cantidad total de productos y total en dinero
$contador_carrito = 0;
$total_carrito = 0.00;

if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $contador_carrito += $item['cantidad'];
        $total_carrito += $item['precio'] * $item['cantidad'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ruaj</title>

  <link rel="icon" href="../img/favicon.png" type="image/png">

  <!-- Estilos -->
  <link rel="stylesheet" href="../css/estilos.css">

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
</head>
<body>

  <nav class="navbar navbar-expand-lg bg-body-tertiary" id="naveg">
    <div class="container-fluid">
      <div class="d-lg-none position-absolute start-50 translate-middle-x" style="top: 15px;">
        <a href="inicio.php">
            <img src="../img/favicon.png" alt="Sheva" width="70" height="70">
        </a>
      </div>
    
      <div class="d-none d-lg-block">
        <a href="inicio.php" class="me-4">
            <img src="../img/favicon.png" alt="Sheva" width="70" height="70">
        </a>
      </div>

      <a class="navbar-brand" id="naveg" href="inicio.php">RUAJ DESIGN</a>
        
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
              data-bs-target="#offcanvasNavbar"
              aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
           aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <a class="navbar-brand" href="inicio.php">
            <img src="../img/favicon.png" alt="Sheva" width="70" height="70">
          </a>
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Sheva</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                  aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" id="ofc">
          <ul class="navbar-nav justify-content-start flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" id="naveg" aria-current="page" href="inicio.php">Inicio</a>
            </li>
            
            <li class="nav-item dropdown-custom">
              <a class="nav-link" id="c" href="../pages/productos_generales.php">Productos</a>
              <div class="dropdown-content">
                <?php include_once("items_dropdown.php"); ?>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="inicio.php#contacto" id="naveg">Contacto</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contacto.php" id="naveg">Armá tu mueble</a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="navbar-social d-flex align-items-center">
      

 <!-- 🛒 Carrito con contador al lado y total al lado del icono -->
<a href="../pages/carrito.php" class="carrito-link d-flex align-items-center text-decoration-none">

  <!-- Contenedor del icono y contador -->
  <div class="carrito-icono position-relative d-flex align-items-center">
    <img src="../img/carrito.png" alt="Carrito" width="32">
    <?php if ($contador_carrito > 0): ?>
      <span class="carrito-contador badge rounded-pill">
        <?= $contador_carrito ?>
      </span>
    <?php endif; ?>
  </div>

  <!-- Contenedor del texto Total carrito al lado del icono -->
  <div class="carrito-info ms-2 d-flex flex-column">
    <span class="carrito-label">Total carrito</span>
    <span class="carrito-total">$<?= number_format($total_carrito, 2) ?></span>
  </div>

</a>



    </div>
  </nav>
