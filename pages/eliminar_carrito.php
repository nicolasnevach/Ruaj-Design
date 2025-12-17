<?php
session_start();

if (isset($_GET['id'])) {
    $clave = $_GET['id']; // no usar htmlspecialchars aquí

    if (isset($_SESSION['carrito'][$clave])) {
        unset($_SESSION['carrito'][$clave]);
    }
}

header('Location: carrito.php');
exit;
?>
