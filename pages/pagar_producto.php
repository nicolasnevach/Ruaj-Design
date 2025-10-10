<?php
// Mostrar todos los errores, excepto los Deprecated
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);

session_start();

// Cargar SDK de Mercado Pago
require __DIR__ . '/../vendor/autoload.php';

use MercadoPago\SDK;
use MercadoPago\Item;
use MercadoPago\Preference;

// ✅ TOKEN DE PRODUCCIÓN (no de prueba)
MercadoPago\SDK::setAccessToken("APP_USR-5066491151862490-091918-e2f93d2552e63ebdf6c50734ae895f53-2703255358");

// Validar que se haya enviado id de producto y cantidad
if (!isset($_POST['id']) || !isset($_POST['cantidad'])) {
    die("Producto o cantidad no especificados.");
}

$id_producto = (int) $_POST['id'];
$cantidad = (int) $_POST['cantidad'];

// Conectar a la base de datos
include_once("../conf/conf.php");
$sql = "SELECT * FROM Producto WHERE id_producto = $id_producto LIMIT 1";
$result = $conf->query($sql);

if ($result->num_rows === 0) {
    die("Producto no encontrado.");
}

$producto = $result->fetch_assoc();

// Crear ítem para Mercado Pago
$item = new Item();
$item->title = $producto['nombre_prod'];
$item->quantity = $cantidad;
$item->unit_price = floatval($producto['precio']);
$item->currency_id = "ARS";

// Crear preferencia
$preference = new Preference();
$preference->items = [$item];

// URLs de retorno
$preference->back_urls = [
    "success" => "https://localhost/ruaj/pages/pago_exitoso.php",
    "failure" => "https://localhost/ruaj/pages/pago_fallido.php",
    "pending" => "https://localhost/ruaj/pages/pago_pendiente.php"
];
$preference->auto_return = "approved";

try {
    $preference->save();
} catch (Exception $e) {
    die("Error al crear la preferencia: " . $e->getMessage());
}

// ✅ Redirigir al checkout real (no sandbox)
if (!empty($preference->init_point)) {
    header("Location: " . $preference->init_point);
    exit;
} else {
    die("No se pudo generar el link de pago.");
}
