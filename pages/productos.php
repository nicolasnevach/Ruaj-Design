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
        
        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">';

        while ($producto = $resultado->fetch_assoc()) {
            // Validar que existan todas las claves necesarias
            if (!isset($producto['nombre_prod'], $producto['precio'], $producto['foto_frente'], $producto['foto_costado'], $producto['id_producto'])) {
                continue;
            }
            
            $nombre = htmlspecialchars($producto['nombre_prod'], ENT_QUOTES, 'UTF-8');
            $precio_base = (float)$producto['precio']; // Precio de respaldo
            $foto_frente = htmlspecialchars($producto['foto_frente'], ENT_QUOTES, 'UTF-8');
            $foto_costado = htmlspecialchars($producto['foto_costado'], ENT_QUOTES, 'UTF-8');
            $id_producto = (int)$producto['id_producto'];

            // 🔹 OBTENER PRECIO DE LA PRIMERA MEDIDA
            $stmt_medidas = $conf->prepare("SELECT precio FROM producto_medidas WHERE id_producto = ? LIMIT 1");
            $stmt_medidas->bind_param("i", $id_producto);
            $stmt_medidas->execute();
            $result_medidas = $stmt_medidas->get_result();
            
            // Si hay medida, usar ese precio; sino usar el precio base
            if ($result_medidas->num_rows > 0) {
                $medida = $result_medidas->fetch_assoc();
                $precio = (float)$medida['precio'];
            } else {
                $precio = $precio_base;
            }
            $stmt_medidas->close();
            
            $precio_descuento = $precio * 0.75; // 25% de descuento

            echo '
            <div class="col">
                <div class="card h-100">
                    <a href="detalle.php?id=' . $id_producto . '" class="img-hover-wrap" style="text-decoration: none; color: inherit;">
                        <img src="../img/' . $foto_frente . '" class="img-front" alt="Vista frontal de ' . $nombre . '" loading="lazy">
                        <img src="../img/' . $foto_costado . '" class="img-hover" alt="Vista lateral de ' . $nombre . '" loading="lazy">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">' . $nombre . '</h5>
                        
                        <div class="mt-auto">
                            <p class="card-text mb-1">
                                <strong style="font-size: 1.1rem;">Precio: $' . htmlspecialchars(number_format($precio, 2), ENT_QUOTES, 'UTF-8') . '</strong>
                            </p>
                            <p class="card-text mb-2" style="font-size: 0.85rem; color: #666;">
                                <strong style="color: var(--color-nav-text); font-size: 1rem;">$' . htmlspecialchars(number_format($precio_descuento, 2), ENT_QUOTES, 'UTF-8') . '</strong> pagando en efectivo
                            </p>
                            <a class="btn btn-medida me-2 mb-2 prod" href="detalle.php?id=' . $id_producto . '">Comprar</a>
                        </div>
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