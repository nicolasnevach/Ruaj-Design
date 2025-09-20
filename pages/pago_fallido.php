<?php
session_start();
include_once("../components/header.php");
?>

<div class="container mt-5 text-center">
  <h1 class="text-danger">❌ Pago fallido</h1>
  <p>Lo sentimos, tu pago no pudo ser procesado.</p>

  <?php if (isset($_GET['status'])): ?>
    <p><strong>Estado:</strong> <?php echo htmlspecialchars($_GET['status']); ?></p>
  <?php endif; ?>

  <a href="carrito.php" class="btn btn-warning mt-3">Volver al carrito</a>
</div>

<?php include_once("../components/footer.php"); ?>
