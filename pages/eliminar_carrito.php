<?php
session_start();

if (isset($_GET['id'])) {
    $clave = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');

    if (isset($_SESSION['carrito'][$clave])) {
        unset($_SESSION['carrito'][$clave]);
    }
}

header('Location: carrito.php');
exit;
?>