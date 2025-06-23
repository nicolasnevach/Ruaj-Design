<?php
session_start();
include_once("../components/header.php");
include_once("../conf/conf.php");

// Verificar que venga el id y sea numérico
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<p class='text-center mt-5'>Producto no especificado.</p>";
  include_once("../components/footer.php");
  exit;
}

$id_producto = (int) $_GET['id'];

// Consulta para obtener datos del producto
$sql = "SELECT * FROM Producto WHERE id_producto = $id_producto LIMIT 1";
$result = $conf->query($sql);

if ($result->num_rows === 0) {
  echo "<p class='text-center mt-5'>Producto no encontrado.</p>";
  include_once("../components/footer.php");
  exit;
}

$producto = $result->fetch_assoc();
?>

<div class="container mt-4">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="inicio.php" class="text-decoration-none" style="color: var(--color-text);">Inicio</a></li>
      <li class="breadcrumb-item"><a href="productos.php" class="text-decoration-none" style="color: var(--color-text);">Productos</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($producto['nombre_prod']); ?></li>
    </ol>
  </nav>

  <!-- Producto principal -->
  <div class="row">
    <!-- Imágenes del producto -->
    <div class="col-md-5">
      <div class="product-image-main mb-3">
        <img src="../img/<?php echo htmlspecialchars($producto['foto']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($producto['nombre_prod']); ?>" id="main-product-image">
      </div>
      <div class="row thumbnails">
        <div class="col-3">
          <img src="../img/<?php echo htmlspecialchars($producto['foto']); ?>" class="img-fluid rounded thumb-img active" alt="Thumbnail">
        </div>
      </div>
    </div>

    <!-- Información del producto -->
    <div class="col-md-7">
      <div class="product-info">
        <div class="product-status mb-2">
          <span class="badge bg-success">Nuevo</span>
          <span class="text-muted ms-2">| +50 vendidos</span>
        </div>
        
        <h1 class="text-start product-title"><?php echo htmlspecialchars($producto['nombre_prod']); ?></h1>

        <div class="price-container mb-4">
          <h2 class="price">$<?php echo number_format($producto['precio'], 2); ?></h2>
        </div>

        <div class="payment-options mb-4">
          <div class="payment-option mb-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="paymentOption" id="onePayment" checked>
              <label class="form-check-label" for="onePayment">
                <span class="payment-title">1 pago de $<?php echo number_format($producto['precio'], 2); ?></span>
              </label>
            </div>
          </div>
          
          <div class="payment-option mb-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="paymentOption" id="installments">
              <label class="form-check-label" for="installments">
                <span class="payment-title">6 cuotas de $<?php echo number_format($producto['precio'] / 6, 2); ?></span>
              </label>
            </div>
          </div>
        </div>

        <!-- Formulario para agregar al carrito -->
        <form action="agregar_carrito.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $producto['id_producto']; ?>">

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
              <li class="mb-2"><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Productos relacionados -->
  <div class="row mt-5">
    <div class="col-12">
      <h2 class="mb-4">Productos relacionados</h2>
    </div>
  </div>
  
  <div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
    <?php
    $categoria_id = $producto['id_categoria'];
    $rel_sql = "SELECT * FROM Producto WHERE id_categoria = $categoria_id AND id_producto != $id_producto LIMIT 4";
    $rel_result = $conf->query($rel_sql);

    if ($rel_result && $rel_result->num_rows > 0) {
      while ($rel = $rel_result->fetch_assoc()) {
        ?>
        <div class="col">
          <div class="card h-100">
            <img src="../img/<?php echo htmlspecialchars($rel['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($rel['nombre_prod']); ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($rel['nombre_prod']); ?></h5>
              <p class="card-text">$<?php echo number_format($rel['precio'], 2); ?></p>
              <a class="btn" id="prod" href="detalle.php?id=<?php echo $rel['id_producto']; ?>">Comprar</a>
            </div>
          </div>
        </div>
        <?php
      }
    } else {
      echo "<p class='text-center'>No hay productos relacionados.</p>";
    }
    ?>
  </div>
</div>

<?php include_once("../components/footer.php"); ?>
