<?php
session_start();
include_once("../conf/conf.php");

// Verificamos que lleguen los datos por POST
if (isset($_POST['id']) && isset($_POST['cantidad'])) {
  $id = (int) $_POST['id'];
  $cantidad = max(1, (int) $_POST['cantidad']); // Por seguridad, mínimo 1

  // Buscar el producto
  $producto = $conf->query("SELECT * FROM Producto WHERE id_producto = $id")->fetch_assoc();

  if ($producto) {
    if (!isset($_SESSION['carrito'])) {
      $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$id])) {
      // Si ya existe, sumamos la cantidad
      $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
    } else {
      // Si no existe, lo agregamos nuevo
      $_SESSION['carrito'][$id] = [
        'nombre' => $producto['nombre_prod'],
        'precio' => $producto['precio'],
        'foto' => $producto['foto'],
        'cantidad' => $cantidad
      ];
    }

    header("Location: carrito.php");
    exit;
  } else {
    // Producto no encontrado
    header("Location: detalle.php?id=$id&error=producto");
    exit;
  }
}

// Si faltan datos
header("Location: productos.php?error=datos");
exit;
