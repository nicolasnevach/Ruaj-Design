<?php
include_once("../components/header.php");
?>
<section class="section-fondo">
  <div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">

      <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://placehold.co/250x100" class="d-block w-100" alt="Imagen destacada 1" width="250" height="100">
    </div>
    <div class="carousel-item">
      <img src="https://placehold.co/250x100" class="d-block w-100" alt="Imagen destacada 2" width="250" height="100">
    </div>
    <div class="carousel-item">
      <img src="https://placehold.co/250x100" class="d-block w-100" alt="Imagen destacada 3" width="250" height="100">
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
  
      <!-- Bloque de texto -->
      <div class="col-lg-6 d-flex flex-column justify-content-start">
        <p class="lead fw-bold fs-3 mb-3" id="dte">Diseñá tu estilo</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
          <a class="btn btn-outline-success btn-lg" id="but" href="contacto.php">Arma tu diseño!</a>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="sobre-nosotros">
  <div class="contenido">
    <h2><strong>Sobre Nosotros!</strong></h2>
    <p>
      Somos una empresa dedicada a la fabricación de una gran variedad de productos realizados en madera de pino, álamo, petiribí y melaminas, todo de excelente calidad, para satisfacer todas las necesidades de amoblamiento de tu hogar y negocio al mejor precio del mercado, brindando también la posibilidad de poder diseñarlos y realizarlos a tu medida.
      Contamos con 10 años de trayectoria en el rubro, lo que garantiza la calidad y dedicación en nuestros productos.
    </p>
  </div>
</section>

<section class="section-fondo marg mg">
  <h1 class="dest titu mg">Productos Destacados:</h1>
  <div class="container" id="ser">
    <!-- 🔹 CAMBIO PRINCIPAL: row-cols-1 row-cols-sm-2 row-cols-lg-3 -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">

<?php
include_once("../conf/conf.php");

$productos_destacados = ['Mesa de Luz Dubai', 'Rack Palermo', 'Recibidor Londres'];

// Usar prepared statement con placeholders
$placeholders = implode(',', array_fill(0, count($productos_destacados), '?'));
$sql = "SELECT * FROM Producto WHERE nombre_prod IN ($placeholders) AND activo = 1";
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
    $precio = htmlspecialchars(number_format($producto['precio'], 2), ENT_QUOTES, 'UTF-8');
    $foto_frente = htmlspecialchars($producto['foto_frente'], ENT_QUOTES, 'UTF-8');
    $id = (int)$producto['id_producto'];
    $foto_costado = htmlspecialchars($producto['foto_costado'], ENT_QUOTES, 'UTF-8');
    ?>

    <div class="col">
      <div class="card h-100">
        <div class="img-hover-wrap">
          <a href="detalle.php?id=<?php echo $id; ?>">
          <img src="../img/<?php echo $foto_frente; ?>" class="img-front" alt="Vista frontal de <?php echo $nombre; ?>" loading="lazy">
          <img src="../img/<?php echo $foto_costado; ?>" class="img-hover" alt="Vista lateral de <?php echo $nombre; ?>" loading="lazy">
        </a>
          
        </div>
        <div class="card-body">
          <h5 class="card-title"><?php echo $nombre; ?></h5>
          <p class="card-text"><strong>Precio: $<?php echo $precio; ?></strong></p>
          <a class="btn btn-outline-success prod"  href="detalle.php?id=<?php echo $id; ?>">Comprar</a>
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
    <img src="../img/planos.jpg" alt="Planos y diseños de muebles personalizados" width="600" height="400" loading="lazy" />
  </div>
</section>

<section id="contacto" class="doble-columna">
  <div class="columna section-fondo">
    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d821.207598262171!2d-58.4609490714786!3d-34.58315789416701!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bcb5e1a9ab5cb5%3A0xa877ff815cbcd7b!2sAv.%20Elcano%204012%2C%20C1427CHR%20Cdad.%20Aut%C3%B3noma%20de%20Buenos%20Aires!5e0!3m2!1ses-419!2sar!4v1758142359212!5m2!1ses-419!2sar" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
                title="Ubicación de Ruaj Design en Chacarita, CABA"></iframe>
    </div>
</div>
  <div class="columna texto section-fondo">
    <h2><strong>CONTACTO FÁBRICA</strong></h2>
    <p><strong>E-mail:</strong> ruajdesign@gmail.com <strong>Whatsapp:</strong> 11-3813-1307 CHACARITA - CABA.</p>
    <a href="https://wa.me/541138131307" target="_blank" rel="noopener noreferrer" class="boton"><strong>Ir a Whatsapp</strong></a>
  </div>
</section>

<?php
include_once("../components/footer.php");
?>