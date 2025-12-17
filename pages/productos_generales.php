<?php
// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("../conf/conf.php");
include_once("../components/header.php");

$sql = "SELECT * FROM producto WHERE activo = 1";
$resultado = $conf->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    echo '<div class="container mt-4">';
    echo '<h2 class="mb-4">Todos los Productos</h2>';
    
    echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">';

    while ($producto = $resultado->fetch_assoc()) {
        // Validar que existan todas las claves necesarias
        if (!isset($producto['id_producto'], $producto['nombre_prod'], $producto['precio'], $producto['foto_frente'], $producto['foto_costado'])) {
            continue;
        }
        
        $id = (int)$producto['id_producto'];
        $nombre = htmlspecialchars($producto['nombre_prod'], ENT_QUOTES, 'UTF-8');
        $precio_base = (float)$producto['precio']; // Precio de respaldo
        $foto_frente = htmlspecialchars($producto['foto_frente'], ENT_QUOTES, 'UTF-8');
        $foto_costado = htmlspecialchars($producto['foto_costado'], ENT_QUOTES, 'UTF-8');

        // 🔹 OBTENER PRECIO DE LA PRIMERA MEDIDA
        $stmt_medidas = $conf->prepare("SELECT precio FROM producto_medidas WHERE id_producto = ? LIMIT 1");
        $stmt_medidas->bind_param("i", $id);
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

        echo '<div class="col">
                <div class="card h-100">
                    
                    <a href="detalle.php?id=' . $id . '" class="img-hover-wrap" style="text-decoration: none; color: inherit;">
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
                            <a class="btn btn-medida me-2 mb-2 prod" href="detalle.php?id=' . $id . '">Comprar</a>
                        </div>
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
