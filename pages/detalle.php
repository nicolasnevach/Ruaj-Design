<?php
session_start();
include_once("../components/header.php");
include_once("../conf/conf.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p class='text-center mt-5'>Producto no especificado.</p>";
    include_once("../components/footer.php");
    exit;
}

$id_producto = (int) $_GET['id'];

// --- Producto principal (prepared statement) ---
$stmt = $conf->prepare("SELECT * FROM Producto WHERE id_producto = ? AND activo = 1 LIMIT 1");
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='text-center mt-5'>Producto no encontrado.</p>";
    include_once("../components/footer.php");
    exit;
}

$producto = $result->fetch_assoc();
$nombre = $producto['nombre_prod'];
$descripcion = $producto['descripcion'];
$precio = $producto['precio'];
$foto_frente = $producto['foto_frente'];
$foto_costado = $producto['foto_costado'];
$foto_zoom = $producto['foto_zoom'];
$id_categoria = $producto['id_categoria'];

$stmt->close();
?>

<div class="container mt-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="inicio.php" class="text-decoration-none" style="color: var(--color-text);">Inicio</a></li>
      <li class="breadcrumb-item"><a href="productos_generales.php" class="text-decoration-none" style="color: var(--color-text);">Productos</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($nombre); ?></li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-md-5">
      <div class="product-image-main mb-3">
        <img src="../img/<?php echo htmlspecialchars($foto_frente); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($nombre); ?>" id="main-product-image">
      </div>

      <div class="row thumbnails gx-2">
        <div class="col-3">
          <img src="../img/<?php echo htmlspecialchars($foto_frente); ?>" class="img-fluid rounded thumb-img" alt="Foto frente" onclick="cambiarImagen(this)">
        </div>
        <div class="col-3">
          <img src="../img/<?php echo htmlspecialchars($foto_costado); ?>" class="img-fluid rounded thumb-img" alt="Foto costado" onclick="cambiarImagen(this)">
        </div>
        <div class="col-3">
          <img src="../img/<?php echo htmlspecialchars($foto_zoom); ?>" class="img-fluid rounded thumb-img" alt="Foto zoom" onclick="cambiarImagen(this)">
        </div>
      </div>
    </div>

    <div class="col-md-7">
      <div class="product-info">
        <div class="product-status mb-2">
          <span class="badge bg-success">Nuevo</span>
          <span class="text-muted ms-2">| +50 vendidos</span>
        </div>

        <h1 class="text-start product-title"><?php echo htmlspecialchars($nombre); ?></h1>

        <div class="price-container mb-4">
          <h2 class="price">$<?php echo number_format($precio, 2); ?></h2>
        </div>

        <div class="row mb-4 align-items-end">
          <div class="col-md-6">
            <form id="formComprar" action="pagar_producto.php" method="POST">
              <input type="hidden" name="id" value="<?php echo $id_producto; ?>">
              <div class="d-flex align-items-center mb-2">
                <label for="quantity" class="me-2">Cantidad:</label>
                <select class="form-select w-25" id="quantity" name="cantidad">
                  <?php for($i=1;$i<=5;$i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                  <?php endfor; ?>
                </select>
              </div>
              <button class="btn w-100 btn-success" type="submit">Comprar ahora</button>
            </form>
          </div>

          <div class="col-md-6">
            <form id="formCarrito" method="POST" action="agregar_carrito.php" class="h-100 d-flex flex-column justify-content-end">
              <input type="hidden" name="id" value="<?php echo $id_producto; ?>">
              <input type="hidden" id="cantidadCarrito" name="cantidad" value="1">
              <button type="submit" class="btn btn-outline-success w-100">
                Agregar al carrito
              </button>
            </form>
          </div>
        </div>

        <div class="card mt-4">
          <div class="card-header">
            <h3>Lo que necesitas saber de este producto</h3>
          </div>
          <div class="card-body">
            <ul class="list-unstyled">
              <li class="mb-2"><strong>Descripción:</strong> <?php echo nl2br(htmlspecialchars($descripcion)); ?></li>
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
    // --- Productos relacionados con prepared statement ---
    $stmt_rel = $conf->prepare("SELECT * FROM Producto WHERE id_categoria = ? AND id_producto != ? AND activo = 1 LIMIT 4");
    $stmt_rel->bind_param("ii", $id_categoria, $id_producto);
    $stmt_rel->execute();
    $rel_result = $stmt_rel->get_result();

    if ($rel_result && $rel_result->num_rows > 0) {
        while ($rel = $rel_result->fetch_assoc()) {
            $rel_nombre = $rel['nombre_prod'];
            $rel_foto = $rel['foto_frente'];
            $rel_precio = $rel['precio'];
            $rel_id = $rel['id_producto'];
    ?>
        <div class="col">
          <div class="card h-100">
            <img src="../img/<?php echo htmlspecialchars($rel_foto); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($rel_nombre); ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($rel_nombre); ?></h5>
              <p class="card-text">$<?php echo number_format($rel_precio, 2); ?></p>
              <a class="btn btn-success" href="detalle.php?id=<?php echo $rel_id; ?>">Comprar</a>
            </div>
          </div>
        </div>
    <?php
        }
    } else {
        echo "<p class='text-center'>No hay productos relacionados.</p>";
    }

    $stmt_rel->close();
    ?>
  </div>
</div>

<script>
  function cambiarImagen(elemento) {
    document.getElementById('main-product-image').src = elemento.src;
  }

  const selectCantidad = document.getElementById('quantity');
  const inputCantidadCarrito = document.getElementById('cantidadCarrito');
  const formCarrito = document.getElementById('formCarrito');

  selectCantidad.addEventListener('change', () => {
    inputCantidadCarrito.value = selectCantidad.value;
  });

  formCarrito.addEventListener('submit', () => {
    inputCantidadCarrito.value = selectCantidad.value;
  });
</script>

<?php include_once("../components/footer.php"); ?>
