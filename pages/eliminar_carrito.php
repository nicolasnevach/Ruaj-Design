<?php
session_start();

if (isset($_GET['id'])) {
    $clave = $_GET['id']; // ahora es un string tipo "123_md5medida"

    if (isset($_SESSION['carrito'][$clave])) {
        unset($_SESSION['carrito'][$clave]);
    }
}

header('Location: carrito.php');
exit;
?>
