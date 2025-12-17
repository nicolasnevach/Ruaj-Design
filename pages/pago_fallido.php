<?php
session_start();

// 🔹 Limpiar datos de compra si el pago falló
if (isset($_SESSION['datos_compra'])) {
    unset($_SESSION['datos_compra']);
}

include_once("../components/header.php");
?>
<main>
<div class="container mt-5 text-center">
  <h1 class="text-danger">❌ Pago fallido</h1>
  <p>Lo sentimos, tu pago no pudo ser procesado.</p>

  <?php if (isset($_GET['status'])): ?>
    <p><strong>Estado:</strong> 
        <?php echo htmlspecialchars($_GET['status'], ENT_QUOTES, 'UTF-8'); ?>
    </p>
  <?php endif; ?>

  <a href="carrito.php" class="btn btn-warning mt-3">Volver al carrito</a>
  <a href="productos_generales.php" class="btn btn-outline-secondary mt-3">Seguir comprando</a>
</div>
</main>
<?php include_once("../components/footer.php"); ?>
