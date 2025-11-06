<?php
session_start();
include_once("../components/header.php");
?>

<div class="container mt-5 text-center">
  <h1 class="text-info">⌛ Pago pendiente</h1>
  <p>Tu pago está siendo procesado. Te notificaremos cuando se confirme.</p>

  <?php if (isset($_GET['status'])): ?>
    <p><strong>Estado:</strong> <?php echo htmlspecialchars($_GET['status'], ENT_QUOTES, 'UTF-8'); ?></p>
  <?php endif; ?>

  <a href="productos_generales.php" class="btn btn-secondary mt-3">Seguir comprando</a>
  <a href="inicio.php" class="btn btn-outline-secondary mt-3">Volver al inicio</a>
</div>

<?php include_once("../components/footer.php"); ?>