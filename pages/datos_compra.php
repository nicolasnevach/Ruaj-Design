<?php
session_start();
include_once("../conf/conf.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibir datos del formulario
    $nombre_completo = trim($_POST['nombre_apellido']);
    $mail = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $comentarios = trim($_POST['comentarios']);
    
    // Calcular el total del carrito
    $carrito = $_SESSION['carrito'] ?? [];
    $total = 0;
    
    foreach ($carrito as $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
    
    // Por ahora subtotal = total (como solicitaste)
    $subtotal = $total;
    
    
    // Validar que los campos obligatorios no estén vacíos
    if (empty($nombre_completo) || empty($mail) || empty($telefono)) {
        header("Location: prepago.php?error=campos_vacios");
        exit();
    }
    
    // Validar email
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        header("Location: prepago.php?error=email_invalido");
        exit();
    }
    
    // Preparar la consulta SQL con prepared statement (seguridad contra SQL injection)
    $sql = "INSERT INTO compras (nombre_completo, mail, telefono, comentarios, subtotal, total) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conf->prepare($sql)) {
        // Vincular parámetros (s=string, i=integer)
        $stmt->bind_param("sssiii", $nombre_completo, $mail, $telefono, $comentarios, $subtotal, $total);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Obtener el ID de la compra insertada
            $id_compra = $stmt->insert_id;
            
            // Guardar el ID en sesión para usarlo después
            $_SESSION['id_compra'] = $id_compra;
            
            // Guardar datos del cliente en sesión por si los necesita Mercado Pago
            $_SESSION['cliente_nombre'] = $nombre_completo;
            $_SESSION['cliente_email'] = $mail;
            $_SESSION['cliente_telefono'] = $telefono;
            
            // Redirigir a la página de pago de Mercado Pago
            header("Location: pagar_carrito.php");
            exit();
        } else {
            // Error al ejecutar
            header("Location: prepago.php?error=bd_error");
            exit();
        }
        
        $stmt->close();
    } else {
        // Error al preparar la consulta
        header("Location: prepago.php?error=bd_error");
        exit();
    }
     
    $conf->close();
    
} else {
    // Si acceden directamente sin POST, redirigir
    header("Location: prepago.php");
    exit();
}
?>