<?php
include_once("../conf/conf.php");
include_once("../components/header.php");

if (isset($_GET['categoria']) && is_numeric($_GET['categoria'])) {
    $categoria_id = (int)$_GET['categoria'];

    // Obtener nombre de la categoría con prepared statement
    $stmt_cat = $conf->prepare("SELECT nombre_cat FROM categorias WHERE id_categoria = ?");
    $stmt_cat->bind_param("i", $categoria_id);
    $stmt_cat->execute();
    $resultado_cat = $stmt_cat->get_result();
    
    $nombre_categoria = "Productos"; // valor por defecto

    if ($resultado_cat && $resultado_cat->num_rows > 0) {
        $cat = $resultado_cat->fetch_assoc();
        if (isset($cat['nombre_cat'])) {
            $nombre_categoria = htmlspecialchars($cat['nombre_cat'], ENT_QUOTES, 'UTF-8');
        }
    }
    $stmt_cat->close();

    // Obtener productos de la categoría con prepared statement
    $stmt = $conf->prepare("SELECT * FROM Producto WHERE id_categoria = ? AND activo = 1");
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        echo '<div class="container mt-4">';
        echo '<h2 class="mb-4">' . $nombre_categoria . '</h2>';
        
        // 🔹 CAMBIO PRINCIPAL: row-cols-1 row-cols-sm-2 row-cols-lg-3
        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">';

        while ($producto = $resultado->fetch_assoc()) {
            // Validar que existan todas las claves necesarias
            if (!isset($producto['nombre_prod'], $producto['precio'], $producto['foto_frente'], $producto['foto_costado'], $producto['id_producto'])) {
                continue;
            }
            
            $nombre = htmlspecialchars($producto['nombre_prod'], ENT_QUOTES, 'UTF-8');
            $precio = htmlspecialchars(number_format($producto['precio'], 2), ENT_QUOTES, 'UTF-8');
            $foto_frente = htmlspecialchars($producto['foto_frente'], ENT_QUOTES, 'UTF-8');
            $foto_costado = htmlspecialchars($producto['foto_costado'], ENT_QUOTES, 'UTF-8');
            $id_producto = (int)$producto['id_producto'];

            echo '
            <div class="col">
                <div class="card h-100">
                    <a href="detalle.php?id=' . $id_producto . '" class="img-hover-wrap" style="text-decoration: none; color: inherit;">
                        <img src="../img/' . $foto_frente . '" class="img-front" alt="Vista frontal de ' . $nombre . '" loading="lazy">
                        <img src="../img/' . $foto_costado . '" class="img-hover" alt="Vista lateral de ' . $nombre . '" loading="lazy">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">' . $nombre . '</h5>
                        <p class="card-text"><strong>Precio: $' . $precio . '</strong></p>
                        <a class="btn btn-outline-success prod" href="detalle.php?id=' . $id_producto . '">Comprar</a>
                    </div>
                </div>
            </div>';
        }

        echo '</div></div>';
    } else {
        echo "<div class='container mt-5'><p class='text-center'>No hay productos disponibles en esta categoría.</p></div>";
    }
    
    $stmt->close();
} else {
    echo "<div class='container mt-5'><div class='alert alert-warning text-center'>No se seleccionó ninguna categoría válida.</div></div>";
}

$conf->close();

include_once("../components/footer.php");
?>