<?php
session_start();
include_once("../conf/conf.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recibir y sanitizar datos del formulario
    $nombre_completo = htmlspecialchars(trim($_POST['nombre_apellido'] ?? ''), ENT_QUOTES, 'UTF-8');
    $mail = htmlspecialchars(trim($_POST['email'] ?? ''), ENT_QUOTES, 'UTF-8');
    $telefono = htmlspecialchars(trim($_POST['telefono'] ?? ''), ENT_QUOTES, 'UTF-8');
    $comentarios = htmlspecialchars(trim($_POST['comentarios'] ?? ''), ENT_QUOTES, 'UTF-8');
    $metodo_envio = htmlspecialchars(trim($_POST['metodo_envio'] ?? ''), ENT_QUOTES, 'UTF-8');
    $direccion_envio = htmlspecialchars(trim($_POST['direccion_envio'] ?? ''), ENT_QUOTES, 'UTF-8');

    // Validar campos obligatorios
    if (empty($nombre_completo) || empty($mail) || empty($telefono)) {
        header("Location: prepago.php?error=campos_vacios");
        exit();
    }

    // Validar email
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        header("Location: prepago.php?error=email_invalido");
        exit();
    }

    // Validar método de envío
    if (empty($metodo_envio)) {
        header("Location: prepago.php?error=envio_no_seleccionado");
        exit();
    }

    // Si elige envío a domicilio, validar dirección
    if ($metodo_envio === "domicilio" && empty($direccion_envio)) {
        header("Location: prepago.php?error=direccion_faltante");
        exit();
    }

    // Obtener carrito
    $carrito = $_SESSION['carrito'] ?? [];
    if (empty($carrito)) {
        header("Location: carrito.php?error=carrito_vacio");
        exit();
    }

    // Calcular el total del carrito
    $total = 0;
    foreach ($carrito as $item) {
        if (!isset($item['precio'], $item['cantidad'])) continue;
        $total += (float)$item['precio'] * (int)$item['cantidad'];
    }

    if ($total <= 0) {
        header("Location: carrito.php?error=total_invalido");
        exit();
    }

    // Guardar en sesión
    $_SESSION['datos_compra'] = [
        'nombre_completo' => $nombre_completo,
        'mail' => $mail,
        'telefono' => $telefono,
        'comentarios' => $comentarios,
        'metodo_envio' => $metodo_envio,
        'direccion_envio' => $metodo_envio === "domicilio" ? $direccion_envio : "Retiro en local",
        'total' => $total
    ];

    // Redirigir al pago
    header("Location: pagar_carrito.php");
    exit();

} else {
    header("Location: prepago.php");
    exit();
}
?>
