<?php
session_start();
include_once("../conf/conf.php");

if (!isset($_POST['id'], $_POST['cantidad'])) {
    header("Location: productos.php?error=datos");
    exit;
}

// Validar y limpiar datos
$id = (int) $_POST['id'];
$cantidad = max(1, (int) $_POST['cantidad']); // cantidad mínima 1

// Prepared statement para mayor seguridad
$stmt = $conf->prepare("SELECT nombre_prod, precio, foto_zoom FROM Producto WHERE id_producto = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$producto = $resultado->fetch_assoc();

if (!$producto) {
    header("Location: detalle.php?id=$id&error=producto");
    exit;
}

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar o actualizar cantidad en el carrito
if (isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
} else {
    $_SESSION['carrito'][$id] = [
        'nombre' => $producto['nombre_prod'],
        'precio'  => $producto['precio'],
        'foto'    => $producto['foto_zoom'],
        'cantidad'=> $cantidad
    ];
}

// Redirigir al detalle del producto con mensaje de éxito
header("Location: detalle.php?id=$id&ok=1");
exit;
?>
