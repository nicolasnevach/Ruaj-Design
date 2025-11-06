<?php
session_start();

// Vaciar el carrito después de la compra
if (isset($_SESSION['carrito'])) {
    unset($_SESSION['carrito']);
}

include_once("../components/header.php");
?>

<div class="container mt-5 text-center">
  <h1 class="text-success">✅ ¡Pago exitoso!</h1>
  <p>Gracias por tu compra. Tu pago fue aprobado.</p>

  <?php if (isset($_GET['payment_id'])): ?>
    <p><strong>ID de pago:</strong> <?php echo htmlspecialchars($_GET['payment_id'], ENT_QUOTES, 'UTF-8'); ?></p>
  <?php endif; ?>

  <?php if (isset($_GET['status'])): ?>
    <p><strong>Estado:</strong> <?php echo htmlspecialchars($_GET['status'], ENT_QUOTES, 'UTF-8'); ?></p>
  <?php endif; ?>

  <a href="productos_generales.php" class="btn btn-primary mt-3">Volver a la tienda</a>
  <a href="inicio.php" class="btn btn-outline-primary mt-3">Ir al inicio</a>
</div>

<?php include_once("../components/footer.php"); ?>