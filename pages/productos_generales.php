<?php
include_once("../conf/conf.php");
include_once("../components/header.php");

$sql = "SELECT * FROM Producto";
$resultado = $conf->query($sql);

if ($resultado->num_rows > 0) {
    echo '<div class="container mt-4">';
    echo '<h2 class="mb-4">Todos los Productos</h2>';
    echo '<div class="row row-cols-1 row-cols-md-3 g-4">';

    while ($producto = $resultado->fetch_assoc()) {
        echo '<div class="col">
                <div class="card h-100">
                    <img src="../img/' . htmlspecialchars($producto['foto']) . '" class="card-img-top" alt="' . htmlspecialchars($producto['nombre_prod']) . '" width="355" height="300">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($producto['nombre_prod']) . '</h5>
                        <p class="card-text">' . htmlspecialchars($producto['descripcion']) . '</p>
                        <p class="card-text"><strong>Precio: $' . number_format($producto['precio'], 2) . '</strong></p>
                        <a class="btn btn-outline-success" href="../pages/detalle.php?id=' . $producto['id_producto'] . '">Comprar</a>
                    </div>
                </div>
              </div>';
    }

    echo '</div></div>';
} else {
    echo '<p>No hay productos disponibles.</p>';
}
include_once("../components/footer.php");
?>
