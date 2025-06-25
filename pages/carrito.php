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
      print '<td><img src="../img/' . $item['foto'] . '" alt="" width="80"></td>';
      print '<td>' . $item['nombre'] . '</td>';
      print '<td>$' . number_format($item['precio'], 2) . '</td>';
      print '<td>' . $item['cantidad'] . '</td>';
      print '<td>$' . number_format($subtotal, 2) . '</td>';
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

    print '<div class="text-end">';
    print '<a href="finalizar_compra.php" class="btn btn-success">Finalizar compra</a>';
    print '</div>';
  }
  ?>
</div>

<?php include_once("../components/footer.php"); ?>
