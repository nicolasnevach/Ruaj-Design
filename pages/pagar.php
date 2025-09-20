<?php
session_start();

// Cargar SDK manualmente
require __DIR__ . '/../libs/mercadopago/mercadopago_autoload.php';
MercadoPago\SDK::setAccessToken("TU_ACCESS_TOKEN_DE_TEST");

$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();
if (empty($carrito)) die("Carrito vacío.");

// Crear preferencia
$preference = new MercadoPago\Preference();
$items = [];
foreach ($carrito as $id => $item) {
    $producto = new MercadoPago\Item();
    $producto->title = $item['nombre'];
    $producto->quantity = $item['cantidad'];
    $producto->unit_price = floatval($item['precio']);
    $items[] = $producto;
}
$preference->items = $items;
$preference->back_urls = [
    "success" => "https://TUSITIO.com/pago_exitoso.php",
    "failure" => "https://TUSITIO.com/pago_fallido.php",
    "pending" => "https://TUSITIO.com/pago_pendiente.php"
];
$preference->auto_return = "approved";
$preference->save();

// Redirigir al checkout
header("Location: " . $preference->init_point);
exit;
