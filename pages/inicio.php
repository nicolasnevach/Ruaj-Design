<?php
include_once("../components/header.php");
?>
<section class="section-fondo">
  <div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">

      <!-- Imagen del mueble -->
      <div class="col-10 col-sm-8 col-lg-6">
        <img src="../img/mueble.jpg" class="d-block mx-lg-auto img-fluid" alt="Diseño de mueble" width="700" height="500" loading="lazy">
      </div>
  
      <!-- Bloque de texto -->
      <div class="col-lg-6 d-flex flex-column justify-content-start">

        <!-- Encabezado principal bien alineado -->
        <h1 class="display-5 fw-bold lh-1 mb-4 ruaj" >RUAJ DESIGN</h1>
        
        <!-- Subtítulo alineado -->
        <p class="lead fw-bold fs-3 mb-3" id = "dte">Diseñá tu estilo</p>
        
        <!-- Botón alineado -->
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
      Somos una empresa dedicada a la fabricación de una gran variedad de productos realizados en madera de pino, álamo, petiribí y melaminas, todo de excelente calidad, para satisfacer todas las necesidades de amoblamiento de tu hogar al mejor precio del mercado, brindando también la posibilidad de poder diseñarlos y realizarlos a tu medida.
      
      Contamos con 10 años de trayectoria en el rubro, lo que garantiza la calidad y dedicación en nuestros productos.
    </p>
  </div>
</section>


<section class="section-fondo marg mg">
  <h1 class="dest titu mg">Productos Destacados:</h1>
  <div class="container" id="ser">
    <div class="row row-cols-1 row-cols-md-3 g-4">

<?php
include_once("../conf/conf.php");

$productos_destacados = ['Mesa de luz Amelia', 'Biblioteca', 'Escritorio Olivia'];
$lista_nombres = "'" . implode("','", $productos_destacados) . "'";

$sql = "SELECT * FROM Producto WHERE nombre_prod IN ($lista_nombres)";
$resultado = $conf->query($sql);

if ($resultado && $resultado->num_rows > 0) {
  while ($producto = $resultado->fetch_assoc()) {
    $nombre = $producto['nombre_prod'];
    $descripcion = $producto['descripcion'];
    $foto = $producto['foto'];
    $id = $producto['id_producto'];
    $foto_alt = $producto['foto_alt'];
    $fotoHover = $foto_alt != "" ? $foto_alt : "fondo.jpg";
    ?>

    <div class="col">
      <div class="card h-100">
        <div class="img-hover-wrap">
          <img src="../img/<?php print $foto; ?>" class="img-front" alt="<?php print $nombre; ?>" width="355" height="200">
          <img src="../img/<?php print $fotoHover; ?>" class="img-hover" alt="Imagen alternativa" width="355" height="200">
        </div>
        <div class="card-body">
          <h5 class="card-title"><?php print $nombre; ?></h5>
          <p class="card-text"><?php print $descripcion; ?></p>
          <a class="btn btn-outline-success" id="prod" href="detalle.php?id=<?php print $id; ?>">Comprar</a>
        </div>
        <div class="card-footer">
          <small class="text-body-secondary">Producto destacado del mes</small>
        </div>
      </div>
    </div>

    <?php
  }
} else {
  print "<p>No hay productos destacados disponibles.</p>";
}
?>

    </div>
  </div>
</section>


<section class="doble-columna">
  <div class="columna texto">
    <h2><strong>PODEMOSASESORARTE</strong></h2>
    <p>Queremos ayudarte a hacer realidad el mueble que soñás!</p>
    <a href="https://wa.me/541138131307" class="boton"><strong>Manos a la obra! Diseñemos tu mueble!</strong></a>
  </div>
  <div class="columna imagenes">
    <img src="https://placehold.co/250x100/" alt="Diseño 1" />
    <img src="https://placehold.co/250x100/" alt="Diseño 2" />
    <img src="https://placehold.co/250x100/" alt="Diseño 3" />
  </div>
</section>

<section id="contacto" class="doble-columna">
  <div class="columna section-fondo">
    <img src="../img/mapa.jpg" alt="Diseño 1" />
  </div>
  <div class="columna texto section-fondo">
    <h2><strong>CONTACTO FÁBRICA
      E-mail: ruajdesign@gmail.com
      Whatsapp: 11-3813-1307
      Dirección: Av. Elcano 4012 CHACARITA - CABA
    </strong></h2>
  </div>
</section>


<?php
include_once("../components/footer.php");
?>