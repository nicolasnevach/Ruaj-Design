<?php
session_start();
require_once '../vendor/autoload.php';
include_once("../conf/conf.php");

// 🔹 Cargar credenciales de producción
MercadoPago\SDK::setAccessToken("APP_USR-1307864970065448-103010-e572d515f5f20e0d12a11c6b7ed8c116-182075690");

// Verificar datos de compra
$carrito = $_SESSION['carrito'] ?? [];
$datos_compra = $_SESSION['datos_compra'] ?? null;

if (empty($carrito) || !$datos_compra) {
    header("Location: carrito.php?error=carrito_vacio");
    exit();
}

try {
    // 🔹 Crear preferencia de pago
    $preference = new MercadoPago\Preference();

    $items = [];
    foreach ($carrito as $item) {
        if (!isset($item['nombre'], $item['precio'], $item['cantidad'])) continue;

        $mp_item = new MercadoPago\Item();
        $mp_item->title = $item['nombre'];
        $mp_item->quantity = (int)$item['cantidad'];
        $mp_item->unit_price = (float)$item['precio'];
        $mp_item->currency_id = "ARS";
        $items[] = $mp_item;
    }

    $preference->items = $items;

    // 🔹 Datos del comprador
    $payer = new MercadoPago\Payer();
    $payer->name = $datos_compra['nombre_completo'];
    $payer->email = $datos_compra['mail'];
    $payer->phone = [
        "number" => $datos_compra['telefono']
    ];
    $preference->payer = $payer;

    // 🔹 Redirecciones
    $base_url = "localhost/ruaj/pages/";

    $preference->back_urls = [
        "success" => $base_url . "pago_exitoso.php",
        "failure" => $base_url . "pago_fallido.php",
        "pending" => $base_url . "pago_pendiente.php"
    ];
    $preference->auto_return = "approved";

    // 🔹 Configuración adicional
    $preference->statement_descriptor = "RUAJ DESIGN";
    $preference->binary_mode = true; // Acepta solo pagos aprobados

    // 🔹 Guardar preferencia
    $preference->save();

    if (!isset($preference->id)) {
        throw new Exception("No se pudo generar la preferencia de pago.");
    }

    // 🔹 Redirigir al checkout de Mercado Pago
    header("Location: " . $preference->init_point);
    exit();

} catch (Exception $e) {
    echo "❌ Error Mercado Pago:<br>" . htmlspecialchars($e->getMessage());
}
?>
