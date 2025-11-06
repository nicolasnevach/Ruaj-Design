<?php
session_start();

// Cargar SDK manualmente
require __DIR__ . '/../libs/mercadopago/mercadopago_autoload.php';

// Configurar Access Token desde variable de entorno o archivo de configuración
$mp_token = getenv('MERCADOPAGO_ACCESS_TOKEN') ?: 'TU_ACCESS_TOKEN_DE_TEST';
MercadoPago\SDK::setAccessToken($mp_token);

// Validar que haya productos en el carrito
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();

if (empty($carrito)) {
    header("Location: carrito.php?error=carrito_vacio");
    exit;
}

// Crear preferencia
$preference = new MercadoPago\Preference();
$items = [];

foreach ($carrito as $id => $item) {
    // Validar que existan todos los campos necesarios
    if (!isset($item['nombre'], $item['cantidad'], $item['precio'])) {
        continue;
    }
    
    // Validar que cantidad y precio sean válidos
    $cantidad = (int) $item['cantidad'];
    $precio = (float) $item['precio'];
    
    if ($cantidad <= 0 || $precio <= 0) {
        continue;
    }
    
    $producto = new MercadoPago\Item();
    $producto->title = htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8');
    $producto->quantity = $cantidad;
    $producto->unit_price = $precio;
    $items[] = $producto;
}

// Validar que haya items válidos
if (empty($items)) {
    header("Location: carrito.php?error=items_invalidos");
    exit;
}

$preference->items = $items;

// URLs de retorno
$base_url = "https://tudominio.com"; // Cambiar por tu dominio real
$preference->back_urls = [
    "success" => $base_url . "/pago_exitoso.php",
    "failure" => $base_url . "/pago_fallido.php",
    "pending" => $base_url . "/pago_pendiente.php"
];
$preference->auto_return = "approved";

// Intentar guardar preferencia con manejo de errores
try {
    $preference->save();
    
    if (!isset($preference->init_point)) {
        throw new Exception("No se pudo generar el link de pago");
    }
    
    // Redirigir al checkout
    header("Location: " . $preference->init_point);
    exit;
    
} catch (Exception $e) {
    error_log("Error Mercado Pago: " . $e->getMessage());
    header("Location: carrito.php?error=pago_error");
    exit;
}
?>