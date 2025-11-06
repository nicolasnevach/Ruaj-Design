<?php
include_once("../conf/conf.php");
include_once("../components/header.php");

$sql = "SELECT * FROM Producto WHERE activo = 1";
$resultado = $conf->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    echo '<div class="container mt-4">';
    echo '<h2 class="mb-4">Todos los Productos</h2>';
    
    // 🔹 CAMBIO PRINCIPAL: row-cols-1 row-cols-sm-2 row-cols-lg-3
    echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">';

    while ($producto = $resultado->fetch_assoc()) {
        // Validar que existan todas las claves necesarias
        if (!isset($producto['id_producto'], $producto['nombre_prod'], $producto['precio'], $producto['foto_frente'], $producto['foto_costado'])) {
            continue;
        }
        
        $id = (int)$producto['id_producto'];
        $nombre = htmlspecialchars($producto['nombre_prod'], ENT_QUOTES, 'UTF-8');
        $precio = htmlspecialchars(number_format($producto['precio'], 2), ENT_QUOTES, 'UTF-8');
        $foto_frente = htmlspecialchars($producto['foto_frente'], ENT_QUOTES, 'UTF-8');
        $foto_costado = htmlspecialchars($producto['foto_costado'], ENT_QUOTES, 'UTF-8');

        echo '<div class="col">
                <div class="card h-100">
                    
                    <a href="detalle.php?id=' . $id . '" class="img-hover-wrap" style="text-decoration: none; color: inherit;">
                        <img src="../img/' . $foto_frente . '" class="img-front" alt="Vista frontal de ' . $nombre . '" loading="lazy">
                        <img src="../img/' . $foto_costado . '" class="img-hover" alt="Vista lateral de ' . $nombre . '" loading="lazy">
                    </a>

                    <div class="card-body">
                        <h5 class="card-title">' . $nombre . '</h5>
                        <p class="card-text"><strong>Precio: $' . $precio . '</strong></p>
                        <a class="btn btn-outline-success prod" href="detalle.php?id=' . $id . '">Comprar</a>
                    </div>
                </div>
              </div>';
    }

    echo '</div></div>';
} else {
    echo '<div class="container mt-4"><p class="text-center">No hay productos disponibles en este momento.</p></div>';
}

$conf->close();
?>

<div class="mg"></div>

<?php
include_once("../components/footer.php");
?>