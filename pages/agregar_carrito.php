<?php
// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("../conf/conf.php");

// Validar que existan todos los datos
if (!isset($_POST['id'], $_POST['cantidad'], $_POST['precio'], $_POST['medida'])) {
    header("Location: productos.php?error=datos");
    exit;
}

// Limpiar y validar datos
$id = (int) $_POST['id'];
$cantidad = max(1, (int) $_POST['cantidad']);
$precio = max(0, (float) $_POST['precio']);
$medida = htmlspecialchars(trim($_POST['medida']), ENT_QUOTES, 'UTF-8');

// Validar que la medida no esté vacía
if (empty($medida)) {
    header("Location: detalle.php?id=$id&error=medida");
    exit;
}

// Consultar producto en la base de datos
$stmt = $conf->prepare("SELECT nombre_prod, foto_zoom FROM producto WHERE id_producto = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$producto = $resultado->fetch_assoc();
$stmt->close();

// Validar que el producto exista
if (!$producto) {
    header("Location: detalle.php?id=$id&error=producto");
    exit;
}

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Clave única por producto + medida
$clave = $id . '_' . md5($medida);

// Agregar o actualizar cantidad en el carrito
if (isset($_SESSION['carrito'][$clave])) {
    $_SESSION['carrito'][$clave]['cantidad'] += $cantidad;
} else {
    $_SESSION['carrito'][$clave] = [
        'nombre'   => $producto['nombre_prod'],
        'precio'   => $precio,
        'foto'     => $producto['foto_zoom'],
        'cantidad' => $cantidad,
        'medida'   => $medida
    ];
}

// Redirigir al detalle con mensaje de éxito
header("Location: detalle.php?id=$id&ok=1");
exit;
?>