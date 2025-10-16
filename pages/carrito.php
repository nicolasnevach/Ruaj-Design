<?php
session_start();
include_once("../components/header.php");

$carrito = $_SESSION['carrito'] ?? [];
$total = 0;

// Calcular subtotales y total
foreach ($carrito as $id => $item) {
    $subtotal = $item['precio'] * $item['cantidad'];
    $carrito[$id]['subtotal'] = $subtotal;
    $total += $subtotal;
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Carrito de compras</h2>

    <?php if (empty($carrito)): ?>
        <p class="text-center">Tu carrito está vacío.</p>
        <a class="btn btn-outline-success" href="../pages/productos_generales.php">Comprar</a>
    <?php else: ?>
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
                    <?php foreach ($carrito as $id => $item): ?>
                        <tr>
                            <td>
                                <img src="../img/<?= htmlspecialchars($item['foto']) ?>" alt="<?= htmlspecialchars($item['nombre']) ?>" width="80">
                            </td>
                            <td><?= htmlspecialchars($item['nombre']) ?></td>
                            <td>$<?= number_format($item['precio'], 2) ?></td>
                            <td><?= (int)$item['cantidad'] ?></td>
                            <td>$<?= number_format($item['subtotal'], 2) ?></td>
                            <td>
                                <a href="eliminar_carrito.php?id=<?= (int)$id ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td colspan="2"><strong>$<?= number_format($total, 2) ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-end mt-3">
            <a href="prepago.php" class="btn btn-success me-2">Finalizar compra</a>
            <a class="btn btn-outline-success" href="../pages/productos_generales.php">Seguir comprando</a>
        </div>
    <?php endif; ?>
</div>

<?php include_once("../components/footer.php"); ?>
