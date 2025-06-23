<?php
session_start();
include_once("../components/header.php");

$carrito = $_SESSION['carrito'] ?? [];
$total = 0;
?>

<div class="container mt-5">
  <h2 class="mb-4">Carrito de compras</h2>

  <?php if (empty($carrito)) : ?>
    <p class="text-center">Tu carrito está vacío.</p>
  <?php else : ?>
    <div class="table-responsive">
      <table class="table align-middle text-center">
        <thead>
          <tr>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Precio unitario</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($carrito as $id => $item) : 
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
          ?>
            <tr>
              <td><img src="../img/<?php echo htmlspecialchars($item['foto']); ?>" alt="" width="80"></td>
              <td><?php echo htmlspecialchars($item['nombre']); ?></td>
              <td>$<?php echo number_format($item['precio'], 2); ?></td>
              <td><?php echo $item['cantidad']; ?></td>
              <td>$<?php echo number_format($subtotal, 2); ?></td>
              <td>
                <a href="eliminar_carrito.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" class="text-end"><strong>Total:</strong></td>
            <td colspan="2"><strong>$<?php echo number_format($total, 2); ?></strong></td>
          </tr>
        </tfoot>
      </table>
    </div>
    <div class="text-end">
      <a href="finalizar_compra.php" class="btn btn-success">Finalizar compra</a>
    </div>
  <?php endif; ?>
</div>

<?php include_once("../components/footer.php"); ?>
