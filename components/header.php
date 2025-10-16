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

    <div class="navbar-social">
      <a href="mailto:ruajdesign@gmail.com" target="_blank">
        <img src="../img/gmail.png" alt="Gmail">
      </a>
      <a href="https://www.instagram.com/ruajmuebles/" target="_blank">
        <img src="../img/instagram.png" alt="Instagram">
      </a>
      <a href="https://www.facebook.com/ruajdesign" target="_blank">
        <img src="../img/facebook.png" alt="Facebook">
      </a>
      <a href="https://wa.me/541138131307" target="_blank">
        <img src="../img/wpp.png" alt="WhatsApp">
      </a>
      <a href="../pages/carrito.php">
        <img src="../img/carrito.png" alt="Carrito">
      </a>
    </div>
  </nav>


