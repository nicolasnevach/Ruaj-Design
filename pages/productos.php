<?php
include_once("../conf/conf.php"); // Conexión
include_once("../components/header.php");

if (isset($_GET['categoria'])) {
    $categoria_id = (int)$_GET['categoria'];

    // 🔹 Obtener nombre de la categoría
    $sql_cat = "SELECT nombre_cat FROM categorias WHERE id_categoria = $categoria_id";
    $resultado_cat = $conf->query($sql_cat);
    $nombre_categoria = "Productos"; // valor por defecto

    if ($resultado_cat && $resultado_cat->num_rows > 0) {
        $cat = $resultado_cat->fetch_assoc();
        $nombre_categoria = htmlspecialchars($cat['nombre_cat']);
    }

    // 🔹 Obtener productos de la categoría
    $sql = "SELECT * FROM Producto WHERE id_categoria = $categoria_id AND activo = 1";
    $resultado = $conf->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        print '<div class="container mt-4">';
        // Aquí reemplazamos "Productos" por el nombre de la categoría
        print '<h2 class="mb-4">' . $nombre_categoria . '</h2>';
        print '<div class="row row-cols-1 row-cols-md-3 g-4">';

        while ($producto = $resultado->fetch_assoc()) {
            $nombre = htmlspecialchars($producto['nombre_prod']);
            $precio = number_format($producto['precio'], 2);
            $foto_frente = $producto['foto_frente'];
            $foto_costado = $producto['foto_costado']; // Hover
            $id_producto = (int)$producto['id_producto'];

            print '
            <div class="col">
                <div class="card h-100">
                    <div class="img-hover-wrap">
                        <img src="../img/' . $foto_frente . '" class="img-front" alt="' . $nombre . ' - Vista frontal" width="355" height="300">
                        <img src="../img/' . $foto_costado . '" class="img-hover" alt="' . $nombre . ' - Vista costado" width="355" height="300">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">' . $nombre . '</h5>
                        <p class="card-text"><strong>Precio: $' . $precio . '</strong></p>
                        <a class="btn btn-outline-success" id="prod" href="../pages/detalle.php?id=' . $id_producto . '">Comprar</a>
                    </div>
                </div>
            </div>';
        }

        print '</div></div>';
    } else {
        print "<div class='container mt-5'><p>No hay productos en esta categoría.</p></div>";
    }
} else {
    print "<div class='container mt-5'><p>No se seleccionó ninguna categoría.</p></div>";
}

include_once("../components/footer.php");
?>
