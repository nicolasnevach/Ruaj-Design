<?php
session_start();
include_once("../components/header.php");

$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();
$total = 0;
?>

<div class="container mt-5">
  <h2 class="mb-4">Carrito de compras</h2>

  <?php
  if (empty($carrito)) {
      print '<p class="text-center">Tu carrito está vacío.</p>';
      print '<a class="btn btn-outline-success" href="../pages/productos_generales.php">Comprar</a>';
  } else {
      print '<div class="table-responsive">';
      print '<table class="table align-middle text-center">';
      print '<thead>
              <tr>
                <th>Imagen</th>
                <th>Producto</th>
                <th>Precio unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acciones</th>
              </tr>
            </thead>';
      print '<tbody>';

      foreach ($carrito as $id => $item) {
          $subtotal = $item['precio'] * $item['cantidad'];
          $total += $subtotal;

          print '<tr>';
          // Imagen del producto (frontal)
          print '<td><img src="../img/' . htmlspecialchars($item['foto']) . '" alt="' . htmlspecialchars($item['nombre']) . '" width="80"></td>';
          // Nombre
          print '<td>' . htmlspecialchars($item['nombre']) . '</td>';
          // Precio unitario
          print '<td>$' . number_format($item['precio'], 2) . '</td>';
          // Cantidad
          print '<td>' . (int)$item['cantidad'] . '</td>';
          // Subtotal
          print '<td>$' . number_format($subtotal, 2) . '</td>';
          // Botón eliminar
          print '<td><a href="eliminar_carrito.php?id=' . $id . '" class="btn btn-danger btn-sm">Eliminar</a></td>';
          print '</tr>';
      }

      print '</tbody>';
      print '<tfoot>';
      print '<tr>
               <td colspan="4" class="text-end"><strong>Total:</strong></td>
               <td colspan="2"><strong>$' . number_format($total, 2) . '</strong></td>
             </tr>';
      print '</tfoot>';
      print '</table>';
      print '</div>';

      print '<div class="text-end mt-3">';
      print '<a href="pagar_carrito.php" class="btn btn-success me-2">Finalizar compra</a>';
      print '<a class="btn btn-outline-success" href="../pages/productos_generales.php">Seguir comprando</a>';
      print '</div>';
  }
  ?>
</div>

<?php include_once("../components/footer.php"); ?>
