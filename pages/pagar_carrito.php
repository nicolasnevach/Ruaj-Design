<?php
session_start();

// Cargar SDK manual (sin Composer)
require __DIR__ . '/../vendor/autoload.php';

// Configurar Access Token de prueba
MercadoPago\SDK::setAccessToken("APP_USR-5066491151862490-091918-e2f93d2552e63ebdf6c50734ae895f53-2703255358");

// Validar que haya productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    die("El carrito está vacío.");
}

$carrito = $_SESSION['carrito'];

// Crear preferencia de Mercado Pago
$preference = new MercadoPago\Preference();
$items = [];

foreach ($carrito as $id => $item) {
    $mp_item = new MercadoPago\Item();
    $mp_item->title = $item['nombre'];
    $mp_item->quantity = (int) $item['cantidad'];
    $mp_item->unit_price = floatval($item['precio']);
    $items[] = $mp_item;
}

$preference->items = $items;

// URLs de retorno
$preference->back_urls = [
    "success" => "https://localhost/ruaj/pages/pago_exitoso.php",
    "failure" => "https://localhost/ruaj/pages/pago_fallido.php",
    "pending" => "https://localhost/ruaj/pages/pago_pendiente.php"
];
$preference->auto_return = "approved";

// Guardar preferencia
$preference->save();

// Redirigir a Mercado Pago
header("Location: " . $preference->init_point);
exit;
