<?php
session_start();
include_once("../conf/conf.php"); // conexión: $conf

if (!isset($_SESSION['datos_compra']) || !isset($_SESSION['carrito'])) {
    header("Location: carrito.php");
    exit();
}

include_once("../components/header.php");

$datos = $_SESSION['datos_compra'];
$carrito = $_SESSION['carrito'];

// ✅ Normalización de datos
if (!isset($datos['subtotal']) || !is_numeric($datos['subtotal'])) {
    $calc_subtotal = 0;
    foreach ($carrito as $it) {
        if (isset($it['precio'], $it['cantidad'])) {
            $calc_subtotal += (float)$it['precio'] * (int)$it['cantidad'];
        }
    }
    $datos['subtotal'] = $calc_subtotal;
}

if (!isset($datos['total']) || !is_numeric($datos['total'])) {
    $datos['total'] = $datos['subtotal'];
}

// ✅ Método y dirección de envío
$metodo_envio = (isset($datos['metodo_envio']) && $datos['metodo_envio'] === 'domicilio') ? 'domicilio' : 'retiro';
$direccion_envio = ($metodo_envio === 'domicilio') ? ($datos['direccion_envio'] ?? '') : '';

// ✅ Sanitización de strings
$nombre_db = $datos['nombre_completo'] ?? '';
$mail_db = $datos['mail'] ?? '';
$telefono_db = isset($datos['telefono']) 
    ? preg_replace('/[^0-9+\s-]/', '', trim((string)$datos['telefono'])) 
    : '';
$comentarios_db = $datos['comentarios'] ?? '';
$subtotal_db = (float)$datos['subtotal'];
$total_db = (float)$datos['total'];

// ✅ Insertar en base de datos
$sql = "INSERT INTO compras (nombre_completo, mail, telefono, comentarios, subtotal, total, metodo_envio, direccion_envio)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

if (!isset($conf) || !$conf) {
    file_put_contents(__DIR__ . '/../error_db.txt', "[".date('Y-m-d H:i:s')."] ❌ No se encontró la conexión a la BD.\n", FILE_APPEND);
} else {
    if ($stmt = $conf->prepare($sql)) {
        $stmt->bind_param(
            "ssssddss",
            $nombre_db,
            $mail_db,
            $telefono_db,
            $comentarios_db,
            $subtotal_db,
            $total_db,
            $metodo_envio,
            $direccion_envio
        );

        if ($stmt->execute()) {
            $id_compra = $stmt->insert_id;

            // ✅ Crear mensaje
            $mensaje = "=== NUEVA COMPRA #$id_compra ===\n";
            $mensaje .= "Fecha: " . date("d/m/Y H:i:s") . "\n";
            $mensaje .= "Cliente: $nombre_db\n";
            $mensaje .= "Email: $mail_db\n";
            $mensaje .= "Teléfono: $telefono_db\n";
            $mensaje .= "Método de envío: $metodo_envio\n";
            if ($metodo_envio === 'domicilio') {
                $mensaje .= "Dirección: $direccion_envio\n";
            }
            $mensaje .= "Subtotal: $" . number_format($subtotal_db, 2) . "\n";
            $mensaje .= "Total: $" . number_format($total_db, 2) . "\n\n";
            $mensaje .= "Productos:\n";
            foreach ($carrito as $it) {
                if (isset($it['nombre'], $it['cantidad'], $it['precio'])) {
                    $mensaje .= "- {$it['nombre']} x{$it['cantidad']} ($" . number_format($it['precio'], 2) . ")\n";
                }
            }
            $mensaje .= "\n----------------------------------------\n\n";

            // ✅ Guardar confirmación
            file_put_contents(__DIR__ . '/../confirmaciones.txt', $mensaje, FILE_APPEND);

            // ✅ Enviar correos (silenciosos)
            $headers = "From: Ruaj Design <noreply@ruajdesign.com>\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            $mensaje_cliente = "Gracias por tu compra. Pedido #$id_compra\n\n";
            $mensaje_cliente .= "Tu pago fue aprobado correctamente.\n";
            $mensaje_cliente .= "Recordá que si seleccionaste envío a domicilio, debés comunicarte con nosotros al 11-3813-1307 para coordinar detalles del envío.\n\n";
            $mensaje_cliente .= $mensaje;

            @mail($mail_db, "Confirmación de compra #$id_compra - Ruaj Design", $mensaje_cliente, $headers);
            @mail("ruajdesign@gmail.com", "Nueva compra #$id_compra", $mensaje, $headers);

            // ✅ Limpiar sesión
            unset($_SESSION['datos_compra']);
            unset($_SESSION['carrito']);
        } else {
            file_put_contents(__DIR__ . '/../error_db.txt', "[".date('Y-m-d H:i:s')."] ❌ Error ejecutando insert: ".$stmt->error."\n", FILE_APPEND);
        }

        $stmt->close();
    } else {
        file_put_contents(__DIR__ . '/../error_db.txt', "[".date('Y-m-d H:i:s')."] ❌ Error preparando query: ".$conf->error."\n", FILE_APPEND);
    }
}
?>

<!-- ✅ Vista -->
<div class="container mt-5 text-center">
  <h1 class="text-success">✅ ¡Pago exitoso!</h1>
  <p>Gracias por tu compra. Tu pago fue aprobado.</p>
  <p>Recibirás un email de confirmación con los detalles de tu pedido.</p>
  <p><strong>Recordá:</strong> si seleccionaste <em>envío a domicilio</em>, vos debés contactarte con nosotros al <strong>11-3813-1307</strong> para coordinar el envío y su costo.</p>

  <?php if (isset($_GET['status'])): ?>
    <p><strong>Estado:</strong> <?php echo htmlspecialchars($_GET['status'], ENT_QUOTES, 'UTF-8'); ?></p>
  <?php endif; ?>

  <a href="productos_generales.php" class="btn btn-outline-success prod">Volver a la tienda</a>
  <a href="inicio.php" class="btn btn-outline-success prod">Ir al inicio</a>
</div>

<?php include_once("../components/footer.php"); ?>
