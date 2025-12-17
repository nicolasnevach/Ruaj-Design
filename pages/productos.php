<?php
include_once("../conf/conf.php");
include_once("../components/header.php");

echo '<main class="container mt-4">'; // 🔹 Envuelve todo en un <main>

if (isset($_GET['categoria']) && is_numeric($_GET['categoria'])) {
    $categoria_id = (int)$_GET['categoria'];

    // Obtener nombre de la categoría
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

    // 🔹 Verificar si existen productos activos o inactivos
    $stmt_activos = $conf->prepare("SELECT COUNT(*) AS total_activos FROM producto WHERE id_categoria = ? AND activo = 1");
    $stmt_activos->bind_param("i", $categoria_id);
    $stmt_activos->execute();
    $result_activos = $stmt_activos->get_result();
    $total_activos = ($result_activos->fetch_assoc())['total_activos'] ?? 0;
    $stmt_activos->close();

    $stmt_inactivos = $conf->prepare("SELECT COUNT(*) AS total_inactivos FROM producto WHERE id_categoria = ? AND activo = 0");
    $stmt_inactivos->bind_param("i", $categoria_id);
    $stmt_inactivos->execute();
    $result_inactivos = $stmt_inactivos->get_result();
    $total_inactivos = ($result_inactivos->fetch_assoc())['total_inactivos'] ?? 0;
    $stmt_inactivos->close();

    // 🔹 Si hay productos activos, los mostramos
    if ($total_activos > 0) {

        $stmt = $conf->prepare("SELECT * FROM producto WHERE id_categoria = ? AND activo = 1");
        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        echo '<h2 class="mb-4">' . $nombre_categoria . '</h2>';
        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">';

        while ($producto = $resultado->fetch_assoc()) {
            if (!isset($producto['nombre_prod'], $producto['precio'], $producto['foto_frente'], $producto['foto_costado'], $producto['id_producto'])) {
                continue;
            }

            $nombre = htmlspecialchars($producto['nombre_prod'], ENT_QUOTES, 'UTF-8');
            $precio_base = (float)$producto['precio'];
            $foto_frente = htmlspecialchars($producto['foto_frente'], ENT_QUOTES, 'UTF-8');
            $foto_costado = htmlspecialchars($producto['foto_costado'], ENT_QUOTES, 'UTF-8');
            $id_producto = (int)$producto['id_producto'];

            // Obtener precio de la primera medida
            $stmt_medidas = $conf->prepare("SELECT precio FROM producto_medidas WHERE id_producto = ? LIMIT 1");
            $stmt_medidas->bind_param("i", $id_producto);
            $stmt_medidas->execute();
            $result_medidas = $stmt_medidas->get_result();

            if ($result_medidas->num_rows > 0) {
                $medida = $result_medidas->fetch_assoc();
                $precio = (float)$medida['precio'];
            } else {
                $precio = $precio_base;
            }
            $stmt_medidas->close();

            $precio_descuento = $precio * 0.75;

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

        echo '</div>'; // Cierre del grid
        $stmt->close();

    } elseif ($total_inactivos > 0) {
        // 🔹 Mostrar mensaje de "Productos en desarrollo"
        echo '
        <section class="text-center mt-5">
            <h2 class="mb-3">' . $nombre_categoria . '</h2>
            <h4 class="text-muted"> Productos en desarrollo</h4>
            <p class="lead" style="max-width:600px; margin:auto;">
                Estamos diseñando y perfeccionando esta línea de productos. Muy pronto estarán disponibles para vos.
            </p>
        </section>';
    } else {
        // 🔹 Si no hay productos de ningún tipo
        echo "<div class='mt-5 text-center'><p>No hay productos disponibles en esta categoría.</p></div>";
    }

} else {
    echo "<div class='mt-5 text-center alert alert-warning'>No se seleccionó ninguna categoría válida.</div>";
}

echo '</main>'; 
$conf->close();
include_once("../components/footer.php");
?>
