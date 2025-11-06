<?php
// APP_USR-5066491151862490-091918-e2f93d2552e63ebdf6c50734ae895f53-2703255358"

session_start();

// Cargar SDK
require __DIR__ . '/../vendor/autoload.php';

// Configurar Access Token desde variable de entorno o archivo de configuración
// NUNCA hardcodear el token en el código
$mp_token = getenv('MERCADOPAGO_ACCESS_TOKEN') ?: 'TU_TOKEN_AQUI'; // Cambiar por tu método de configuración
MercadoPago\SDK::setAccessToken($mp_token);

// Validar que haya productos en el carrito
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: carrito.php?error=carrito_vacio");
    exit;
}

$carrito = $_SESSION['carrito'];

// Crear preferencia de Mercado Pago
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
    
    $mp_item = new MercadoPago\Item();
    $mp_item->title = htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8');
    $mp_item->quantity = $cantidad;
    $mp_item->unit_price = $precio;
    $items[] = $mp_item;
}

// Validar que haya items válidos
if (empty($items)) {
    header("Location: carrito.php?error=items_invalidos");
    exit;
}

$preference->items = $items;

// URLs de retorno (usar variable o constante, no hardcodear)
$base_url = "https://tudominio.com"; // Cambiar por tu dominio real
$preference->back_urls = [
    "success" => $base_url . "/ruaj/pages/pago_exitoso.php",
    "failure" => $base_url . "/ruaj/pages/pago_fallido.php",
    "pending" => $base_url . "/ruaj/pages/pago_pendiente.php"
];
$preference->auto_return = "approved";

// Intentar guardar preferencia con manejo de errores
try {
    $preference->save();
    
    // Validar que se haya generado el init_point
    if (!isset($preference->init_point)) {
        throw new Exception("No se pudo generar el link de pago");
    }
    
    // Redirigir a Mercado Pago
    header("Location: " . $preference->init_point);
    exit;
    
} catch (Exception $e) {
    // Registrar error en log
    error_log("Error Mercado Pago: " . $e->getMessage());
    
    // Redirigir con mensaje de error
    header("Location: carrito.php?error=pago_error");
    exit;
}
?>