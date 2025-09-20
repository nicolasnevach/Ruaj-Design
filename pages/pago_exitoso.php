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
    <p><strong>ID de pago:</strong> <?php echo htmlspecialchars($_GET['payment_id']); ?></p>
  <?php endif; ?>

  <?php if (isset($_GET['status'])): ?>
    <p><strong>Estado:</strong> <?php echo htmlspecialchars($_GET['status']); ?></p>
  <?php endif; ?>

  <a href="productos.php" class="btn btn-primary mt-3">Volver a la tienda</a>
</div>

<?php include_once("../components/footer.php"); ?>
