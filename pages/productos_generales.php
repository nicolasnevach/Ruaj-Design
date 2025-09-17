<?php
include_once("../conf/conf.php");
include_once("../components/header.php");
?>

<?php
$sql = "SELECT * FROM Producto";
$resultado = $conf->query($sql);

if ($resultado->num_rows > 0) {
    print '<div class="container mt-4">';
    print '<h2 class="mb-4">Todos los Productos</h2>';
    print '<div class="row row-cols-1 row-cols-md-3 g-4">';

    while ($producto = $resultado->fetch_assoc()) {
        $id = $producto['id_producto'];
        $nombre = $producto['nombre_prod'];
        $descripcion = $producto['descripcion'];
        $precio = $producto['precio'];
        $foto = $producto['foto'];
        $foto_alt = $producto['foto_alt']; // Nueva variable para la imagen hover

        print '<div class="col">
                <div class="card h-100">
                    <div class="img-hover-wrap">
                        <img src="../img/' . $foto . '" class="img-front" alt="' . $nombre . '">
                        <img src="../img/' . $foto_alt . '" class="img-hover" alt="' . $nombre . ' - Vista alternativa">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">' . $nombre . '</h5>
                        <p class="card-text">' . $descripcion . '</p>
                        <p class="card-text"><strong>Precio: $' . $precio . '</strong></p>
                        <a class="btn btn-outline-success" href="../pages/detalle.php?id=' . $id . '">Comprar</a>
                    </div>
                </div>
              </div>';
    }

    print '</div></div>';
} else {
    print '<p>No hay productos disponibles.</p>';
}
?>

<div class = "mg"></div>

<?php
include_once("../components/footer.php");
?>