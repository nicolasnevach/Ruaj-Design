<?php
session_start();
include_once("../conf/conf.php");

if (isset($_POST['id']) && isset($_POST['cantidad'])) {
  $id = (int) $_POST['id'];
  $cantidad = (int) $_POST['cantidad'];
  if ($cantidad < 1) {
    $cantidad = 1;
  }

  $sql = "SELECT * FROM Producto WHERE id_producto = $id";
  $resultado = $conf->query($sql);
  $producto = $resultado->fetch_assoc();

  if ($producto) {
    if (!isset($_SESSION['carrito'])) {
      $_SESSION['carrito'] = array();
    }

    if (isset($_SESSION['carrito'][$id])) {
      $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
    } else {
      $_SESSION['carrito'][$id] = array(
        'nombre' => $producto['nombre_prod'],
        'precio' => $producto['precio'],
        'foto' => $producto['foto'],
        'cantidad' => $cantidad
      );
    }

    header("Location: carrito.php");
    exit;
  } else {
    header("Location: detalle.php?id=$id&error=producto");
    exit;
  }
}

header("Location: productos.php?error=datos");
exit;
?>
