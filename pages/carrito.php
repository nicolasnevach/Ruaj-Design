<?php
// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../components/header.php");

// Obtener carrito de la sesión
$carrito = $_SESSION['carrito'] ?? [];
$total = 0;

// Calcular subtotales
foreach ($carrito as $id => $item) {
    if (!isset($item['precio'], $item['cantidad'])) {
        continue;
    }
    $subtotal = (float)$item['precio'] * (int)$item['cantidad'];
    $carrito[$id]['subtotal'] = $subtotal;
    $total += $subtotal;
}
?>

<main>
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
                            <th scope="col">Imagen</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Medida</th>
                            <th scope="col">Precio unitario</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Subtotal</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carrito as $clave => $item): ?>
                            <?php if (!isset($item['foto'], $item['nombre'], $item['medida'], $item['precio'], $item['cantidad'], $item['subtotal'])) continue; ?>
                            <tr>
                                <td>
                                    <img src="../img/<?= htmlspecialchars($item['foto'], ENT_QUOTES, 'UTF-8') ?>" 
                                         alt="Imagen de <?= htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8') ?>" 
                                         width="80" height="80">
                                </td>
                                <td><?= htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($item['medida'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td>$<?= htmlspecialchars(number_format($item['precio'], 2), ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars((int)$item['cantidad'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td>$<?= htmlspecialchars(number_format($item['subtotal'], 2), ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <a href="eliminar_carrito.php?id=<?= urlencode($clave) ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('¿Seguro que deseas eliminar este producto?')">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end"><strong>Total:</strong></td>
                            <td colspan="2"><strong>$<?= htmlspecialchars(number_format($total, 2), ENT_QUOTES, 'UTF-8') ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="text-end mt-3">
                <a href="prepago.php" class="btn btn-success me-2">Finalizar compra</a>
                <a class="btn btn-outline-success prod" href="../pages/productos_generales.php">Seguir comprando</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include_once("../components/footer.php"); ?>