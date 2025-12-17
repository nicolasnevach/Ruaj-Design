<?php
// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


include_once(__DIR__ . "/../components/header.php");
?>
<section class="section-fondo">
  <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://placehold.co/1920x600" class="d-block w-100" alt="Imagen destacada 1">
    </div>

    <div class="carousel-item">
      <img src="https://placehold.co/1920x600" class="d-block w-100" alt="Imagen destacada 2">
    </div>

    <div class="carousel-item">
      <img src="https://placehold.co/1920x600" class="d-block w-100" alt="Imagen destacada 3">
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Siguiente</span>
  </button>

</div>

   

  <div class="text-center py-4">
    <p class="lead fw-bold fs-3 mb-3" id="dte">Diseñá tu estilo</p>
    <a class="btn btn-outline-success btn-lg" id="but" href="contacto.php">Arma tu diseño!</a>
  </div>
</section>

<section class="sobre-nosotros">
  <div class="contenido">
    <h2><strong>Sobre Nosotros!</strong></h2>
    <p>
      Somos una empresa dedicada a la fabricación de una gran variedad de productos realizados en madera de pino, álamo, petiribí y melaminas, todo de excelente calidad, para satisfacer todas las necesidades de amoblamiento de tu hogar y negocio al mejor precio del mercado, brindando también la posibilidad de poder diseñarlos y realizarlos a tu medida.
      Contamos con más de 10 años de trayectoria en el rubro, lo que garantiza la calidad y dedicación en nuestros productos.
    </p>
  </div>
</section>

<section class="marg mg" style="padding: 60px 0; background-color: var(--color-background);">
  <h1 class="dest titu mg">Productos Destacados:</h1>
  <div class="container" id="ser">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">

<?php
include_once(__DIR__ . "/../conf/conf.php");

$productos_destacados = ['Mesa de Luz Dubai', 'Comoda Venecia 4 Cajones', 'Rack Palermo'];

// Usar prepared statement con placeholders
$placeholders = implode(',', array_fill(0, count($productos_destacados), '?'));
$sql = "SELECT * FROM producto WHERE nombre_prod IN ($placeholders) AND activo = 1";
$stmt = $conf->prepare($sql);

// Bind dinámico
$types = str_repeat('s', count($productos_destacados));
$stmt->bind_param($types, ...$productos_destacados);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado && $resultado->num_rows > 0) {
  while ($producto = $resultado->fetch_assoc()) {
    if (!isset($producto['nombre_prod'], $producto['precio'], $producto['foto_frente'], $producto['id_producto'], $producto['foto_costado'])) {
        continue;
    }
    $nombre = htmlspecialchars($producto['nombre_prod'], ENT_QUOTES, 'UTF-8');
    $precio_base = (float)$producto['precio'];
    $foto_frente = htmlspecialchars($producto['foto_frente'], ENT_QUOTES, 'UTF-8');
    $id = (int)$producto['id_producto'];
    $foto_costado = htmlspecialchars($producto['foto_costado'], ENT_QUOTES, 'UTF-8');

    $stmt_medidas = $conf->prepare("SELECT precio FROM producto_medidas WHERE id_producto = ? LIMIT 1");
    $stmt_medidas->bind_param("i", $id);
    $stmt_medidas->execute();
    $result_medidas = $stmt_medidas->get_result();
    
    if ($result_medidas->num_rows > 0) {
        $medida = $result_medidas->fetch_assoc();
        $precio = (float)$medida['precio'];
    } else {
        $precio = $precio_base;
    }
    $stmt_medidas->close();
    
    $precio_descuento = $precio * 0.75;
    ?>

    <div class="col">
      <div class="card h-100">
        <a href="detalle.php?id=<?php echo $id; ?>" class="img-hover-wrap" style="text-decoration: none; color: inherit;">
          <img src="../img/<?php echo $foto_frente; ?>" class="img-front" alt="Vista frontal de <?php echo $nombre; ?>" loading="lazy">
          <img src="../img/<?php echo $foto_costado; ?>" class="img-hover" alt="Vista lateral de <?php echo $nombre; ?>" loading="lazy">
        </a>
        
        <div class="card-body d-flex flex-column">
          <h5 class="card-title"><?php echo $nombre; ?></h5>
          
          <div class="mt-auto">
            <p class="card-text mb-1">
              <strong style="font-size: 1.1rem;">Precio: $<?php echo htmlspecialchars(number_format($precio, 2), ENT_QUOTES, 'UTF-8'); ?></strong>
            </p>
            <p class="card-text mb-2" style="font-size: 0.85rem; color: #666;">
              <strong style="color: var(--color-nav-text); font-size: 1rem;">$<?php echo htmlspecialchars(number_format($precio_descuento, 2), ENT_QUOTES, 'UTF-8'); ?></strong> pagando en efectivo
            </p>
            <a class="btn btn-medida me-2 mb-2 prod" href="detalle.php?id=<?php echo $id; ?>">Comprar</a>
          </div>
        </div>
        <div class="card-footer">
          <small class="text-body-secondary">Producto destacado del mes</small>
        </div>
      </div>
    </div>

    <?php
  }
} else {
  echo "<p>No hay productos destacados disponibles.</p>";
}

$stmt->close();
$conf->close();
?>

    </div>
  </div>
</section>

<section class="doble-columna">
  <div class="columna texto">
    <h2><strong>PODEMOS ASESORARTE</strong></h2>
    <p>Queremos ayudarte a hacer realidad el mueble que soñás!</p>
    <a target="_blank" rel="noopener noreferrer" href="https://wa.me/541138131307" class="boton"><strong>Manos a la obra! Diseñemos tu mueble!</strong></a>
  </div>
  <div class="columna imagenes">
    <img src="../img/planos2.jpg" alt="Planos y diseños de muebles personalizados" width="600" height="400" loading="lazy" />
  </div>
</section>

<section id="contacto" class="doble-columna section-fondo-contacto">
  <div class="columna">
    <div class="map-container">
         <img src="../img/mapa.jpg" alt="Mapa fábrica" width="932" height="513" loading="lazy" />
    </div>
  </div>
  <div class="columna columna-texto-contacto">
    <h2><strong>CONTACTO FÁBRICA</strong></h2>
    <p><strong>E-mail:</strong> ruajdesign@gmail.com <br> <strong>Whatsapp:</strong> 11-3813-1307 <br> CHACARITA - CABA.</p>
    <a href="https://wa.me/541138131307" target="_blank" rel="noopener noreferrer" class="boton"><strong>Ir a Whatsapp</strong></a>
  </div>
</section>

<?php
include_once(__DIR__ . "/../components/footer.php");
?>
