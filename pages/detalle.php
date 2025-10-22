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

// --- Producto principal ---
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

// --- Obtener medidas del producto ---
$stmt_medidas = $conf->prepare("SELECT * FROM producto_medidas WHERE id_producto = ?");
$stmt_medidas->bind_param("i", $id_producto);
$stmt_medidas->execute();
$result_medidas = $stmt_medidas->get_result();
$medidas = [];
while ($row = $result_medidas->fetch_assoc()) {
    $medidas[] = $row;
}
$stmt_medidas->close();

// --- Determinar primera medida ---
$primeraMedida = !empty($medidas) ? $medidas[0] : ['medida'=>'', 'precio'=>$precio];
?>

<link rel="stylesheet" href="../css/estilos.css">

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
        <img src="../img/<?php echo htmlspecialchars($foto_frente); ?>" 
             class="img-fluid rounded" 
             alt="<?php echo htmlspecialchars($nombre); ?>" 
             id="main-product-image"
             onclick="abrirZoom()">
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

        <!-- Precio -->
        <div class="price-container mb-4">
          <h2 class="price">Precio: $<span id="precioActual"><?php echo number_format($primeraMedida['precio'], 2); ?></span></h2>
        </div>

        <!-- Medidas -->
        <?php if (!empty($medidas)) : ?>
          <div class="mb-3">
            <label class="fw-bold mb-2 d-block">Seleccioná una medida:</label>
            <div id="opcionesMedidas">
              <?php foreach ($medidas as $m) : ?>
                <button type="button"
                        class="btn btn-medida me-2 mb-2 <?php echo ($m === $primeraMedida) ? 'activo' : ''; ?>"
                        data-precio="<?php echo $m['precio']; ?>"
                        data-medida="<?php echo htmlspecialchars($m['medida']); ?>">
                  <?php echo htmlspecialchars($m['medida']); ?>
                </button>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- Formulario carrito -->
        <div class="producto-compra mb-4">
          <form id="formCarrito" method="POST" action="agregar_carrito.php" class="mt-3">
            <input type="hidden" name="id" value="<?php echo $id_producto; ?>">
            <input type="hidden" id="cantidadCarrito" name="cantidad" value="1">
            <input type="hidden" id="medidaCarrito" name="medida" value="<?php echo htmlspecialchars($primeraMedida['medida']); ?>">
            <input type="hidden" id="precioCarrito" name="precio" value="<?php echo $primeraMedida['precio']; ?>">

            <label for="quantity" class="me-2">Cantidad:</label>
            <select class="form-select w-auto d-inline-block" id="quantity" name="cantidad">
              <?php for($i=1;$i<=5;$i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              <?php endfor; ?>
            </select>

            <button type="submit" class="btn btn-outline-success btn-agregar w-100 mt-2">
              Agregar al carrito
            </button>
          </form>
        </div>

        <!-- Descripción -->
        <div class="card mt-4">
          <div class="card-header">
            <h3>Lo que necesitas saber de este producto</h3>
          </div>
          <div class="card-body">
            <ul class="list-unstyled">
              <li class="mb-2"><p><strong>Descripción:</strong></p> <?php echo nl2br(htmlspecialchars($descripcion)); ?></li>
              <p><strong>Envíos a todo el país:</strong> <br><br>

Realizamos envíos a domicilio en todo el territorio nacional.
El costo del envío depende de la ubicación y se coordina directamente con nuestro equipo al momento de la compra.
<strong>El valor del flete corre por cuenta del cliente.</strong> <br><br>

<strong>Importante:</strong> Ruaj no se responsabiliza por posibles daños que puedan ocurrir durante el traslado.

Para consultas o pedidos, escribinos por WhatsApp al +54 11 3813-1307.</p>
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

<!-- Modal de Zoom -->
<div class="zoom-modal" id="zoomModal">
  <button class="close-btn" onclick="cerrarZoom()">×</button>
  <div class="zoom-content">
    <img id="zoomImage" class="zoom-image" src="" alt="Zoom">
  </div>
  <div class="zoom-controls">
    <button class="zoom-btn" onclick="zoomOut()" title="Alejar">−</button>
    <span class="zoom-level" id="zoomLevel">100%</span>
    <button class="zoom-btn" onclick="zoomIn()" title="Acercar">+</button>
    <button class="zoom-btn" onclick="resetZoom()" title="Restablecer">⟲</button>
  </div>
</div>

<script>
  // Funciones de zoom
  let zoomLevel = 1, isDragging = false, startX, startY, translateX = 0, translateY = 0;

  function cambiarImagen(elemento){document.getElementById('main-product-image').src = elemento.src;}
  function abrirZoom(){const mainImg=document.getElementById('main-product-image');const zoomImg=document.getElementById('zoomImage');const modal=document.getElementById('zoomModal');zoomImg.src=mainImg.src;modal.classList.add('active');resetZoom();document.body.style.overflow='hidden';}
  function cerrarZoom(){document.getElementById('zoomModal').classList.remove('active');document.body.style.overflow='';}
  function zoomIn(){zoomLevel=Math.min(zoomLevel+0.25,3);aplicarZoom();}
  function zoomOut(){zoomLevel=Math.max(zoomLevel-0.25,0.5);aplicarZoom();}
  function resetZoom(){zoomLevel=1;translateX=0;translateY=0;aplicarZoom();}
  function aplicarZoom(){const img=document.getElementById('zoomImage');img.style.transform=`scale(${zoomLevel}) translate(${translateX}px, ${translateY}px)`;document.getElementById('zoomLevel').textContent=Math.round(zoomLevel*100)+'%';img.classList.toggle('zoomed', zoomLevel>1);}
  document.getElementById('zoomImage').addEventListener('mousedown', (e)=>{if(zoomLevel>1){isDragging=true;startX=e.clientX-translateX;startY=e.clientY-translateY;e.preventDefault();}});
  document.addEventListener('mousemove', (e)=>{if(isDragging){translateX=e.clientX-startX;translateY=e.clientY-startY;aplicarZoom();}});
  document.addEventListener('mouseup', ()=>{isDragging=false;});
  document.addEventListener('keydown', (e)=>{if(e.key==='Escape') cerrarZoom();});
  document.getElementById('zoomModal').addEventListener('click', (e)=>{if(e.target.id==='zoomModal') cerrarZoom();});
  document.getElementById('zoomImage').addEventListener('wheel',(e)=>{e.preventDefault();e.deltaY<0?zoomIn():zoomOut();});

  // Cantidad y carrito
  const selectCantidad = document.getElementById('quantity');
  const inputCantidadCarrito = document.getElementById('cantidadCarrito');
  const formCarrito = document.getElementById('formCarrito');
  selectCantidad.addEventListener('change', ()=>{inputCantidadCarrito.value = selectCantidad.value;});
  formCarrito.addEventListener('submit', ()=>{inputCantidadCarrito.value = selectCantidad.value;});

  // Botones de medida
  const precioCarrito = document.getElementById('precioCarrito');
  const medidaCarrito = document.getElementById('medidaCarrito');
  document.querySelectorAll('.btn-medida').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      document.querySelectorAll('.btn-medida').forEach(b=>b.classList.remove('activo'));
      btn.classList.add('activo');
      precioCarrito.value = btn.dataset.precio;
      medidaCarrito.value = btn.dataset.medida;
      document.getElementById('precioActual').textContent = Number(btn.dataset.precio).toLocaleString('es-AR', {minimumFractionDigits:2});
    });
  });
</script>

<?php include_once("../components/footer.php"); ?>
