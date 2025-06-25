<?php
session_start();
include_once("../components/header.php");
include_once("../conf/conf.php");
?>

<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  print "<p class='text-center mt-5'>Producto no especificado.</p>";
  include_once("../components/footer.php");
  exit;
}

$id_producto = (int) $_GET['id'];
$sql = "SELECT * FROM Producto WHERE id_producto = $id_producto LIMIT 1";
$result = $conf->query($sql);

if ($result->num_rows === 0) {
  print "<p class='text-center mt-5'>Producto no encontrado.</p>";
  include_once("../components/footer.php");
  exit;
}

$producto = $result->fetch_assoc();
$nombre = $producto['nombre_prod'];
$descripcion = $producto['descripcion'];
$precio = $producto['precio'];
$foto = $producto['foto'];
$id_categoria = $producto['id_categoria'];
?>

<div class="container mt-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="inicio.php" class="text-decoration-none" style="color: var(--color-text);">Inicio</a></li>
      <li class="breadcrumb-item"><a href="productos.php" class="text-decoration-none" style="color: var(--color-text);">Productos</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php print $nombre; ?></li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-md-5">
      <div class="product-image-main mb-3">
        <img src="../img/<?php print $foto; ?>" class="img-fluid rounded" alt="<?php print $nombre; ?>" id="main-product-image">
      </div>
      <div class="row thumbnails">
        <div class="col-3">
          <img src="../img/<?php print $foto; ?>" class="img-fluid rounded thumb-img active" alt="Thumbnail">
        </div>
      </div>
    </div>

    <div class="col-md-7">
      <div class="product-info">
        <div class="product-status mb-2">
          <span class="badge bg-success">Nuevo</span>
          <span class="text-muted ms-2">| +50 vendidos</span>
        </div>
        
        <h1 class="text-start product-title"><?php print $nombre; ?></h1>

        <div class="price-container mb-4">
          <h2 class="price">$<?php print $precio; ?></h2>
        </div>

        <div class="payment-options mb-4">
          <div class="payment-option mb-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="paymentOption" id="onePayment" checked>
              <label class="form-check-label" for="onePayment">
                <span class="payment-title">1 pago de $<?php print $precio; ?></span>
              </label>
            </div>
          </div>
          
          <div class="payment-option mb-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="paymentOption" id="installments">
              <label class="form-check-label" for="installments">
                <span class="payment-title">6 cuotas de $<?php print round($precio / 6, 2); ?></span>
              </label>
            </div>
          </div>
        </div>

        <form action="agregar_carrito.php" method="POST">
          <input type="hidden" name="id" value="<?php print $id_producto; ?>">

          <div class="stock mb-4">
            <div class="d-flex align-items-center">
              <label for="quantity" class="me-2">Cantidad:</label>
              <select class="form-select w-25" id="quantity" name="cantidad">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6 mb-2 mb-md-0">
              <button class="btn w-100" type="button" id="env">Comprar ahora</button>
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-outline-success w-100">Agregar al carrito</button>
            </div>
          </div>
        </form>

        <div class="card">
          <div class="card-header">
            <h3>Lo que necesitas saber de este producto</h3>
          </div>
          <div class="card-body">
            <ul class="list-unstyled">
              <li class="mb-2"><strong>Descripción:</strong> <?php print nl2br($descripcion); ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-12">
      <h2 class="mb-4">Productos relacionados</h2>
    </div>
  </div>
  
  <div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
    <?php
    $rel_sql = "SELECT * FROM Producto WHERE id_categoria = $id_categoria AND id_producto != $id_producto LIMIT 4";
    $rel_result = $conf->query($rel_sql);

    if ($rel_result && $rel_result->num_rows > 0) {
      while ($rel = $rel_result->fetch_assoc()) {
        $rel_nombre = $rel['nombre_prod'];
        $rel_foto = $rel['foto'];
        $rel_precio = $rel['precio'];
        $rel_id = $rel['id_producto'];
    ?>
        <div class="col">
          <div class="card h-100">
            <img src="../img/<?php print $rel_foto; ?>" class="card-img-top" alt="<?php print $rel_nombre; ?>">
            <div class="card-body">
              <h5 class="card-title"><?php print $rel_nombre; ?></h5>
              <p class="card-text">$<?php print $rel_precio; ?></p>
              <a class="btn" id="prod" href="detalle.php?id=<?php print $rel_id; ?>">Comprar</a>
            </div>
          </div>
        </div>
    <?php
      }
    } else {
      print "<p class='text-center'>No hay productos relacionados.</p>";
    }
    ?>
  </div>
</div>

<?php include_once("../components/footer.php"); ?>
