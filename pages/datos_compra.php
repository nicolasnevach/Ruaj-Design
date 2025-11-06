<?php
session_start();
include_once("../conf/conf.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibir y sanitizar datos del formulario
    $nombre_completo = htmlspecialchars(trim($_POST['nombre_apellido']), ENT_QUOTES, 'UTF-8');
    $mail = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
    $telefono = htmlspecialchars(trim($_POST['telefono']), ENT_QUOTES, 'UTF-8');
    $comentarios = htmlspecialchars(trim($_POST['comentarios']), ENT_QUOTES, 'UTF-8');
    
    // Validar que los campos obligatorios no estén vacíos
    if (empty($nombre_completo) || empty($mail) || empty($telefono)) {
        header("Location: prepago.php?error=campos_vacios");
        exit();
    }
    
    // Validar longitud de campos
    if (strlen($nombre_completo) > 100 || strlen($mail) > 100 || strlen($telefono) > 20) {
        header("Location: prepago.php?error=datos_largos");
        exit();
    }
    
    // Validar email
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        header("Location: prepago.php?error=email_invalido");
        exit();
    }
    
    // Obtener carrito y validar que no esté vacío
    $carrito = $_SESSION['carrito'] ?? [];
    
    if (empty($carrito)) {
        header("Location: carrito.php?error=carrito_vacio");
        exit();
    }
    
    // Calcular el total del carrito
    $total = 0;
    
    foreach ($carrito as $item) {
        // Validar que existan las claves necesarias
        if (!isset($item['precio'], $item['cantidad'])) {
            continue;
        }
        $total += (float)$item['precio'] * (int)$item['cantidad'];
    }
    
    // Validar que el total sea mayor a cero
    if ($total <= 0) {
        header("Location: carrito.php?error=total_invalido");
        exit();
    }
    
    // Por ahora subtotal = total
    $subtotal = (float)$total;
    $total = (float)$total;
    
    // Preparar la consulta SQL con prepared statement
    $sql = "INSERT INTO compras (nombre_completo, mail, telefono, comentarios, subtotal, total) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conf->prepare($sql)) {
        // Vincular parámetros (s=string, d=double para decimales)
        $stmt->bind_param("ssssdd", $nombre_completo, $mail, $telefono, $comentarios, $subtotal, $total);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Obtener el ID de la compra insertada
            $id_compra = $stmt->insert_id;
            
            // Guardar el ID en sesión
            $_SESSION['id_compra'] = $id_compra;
            
            // Guardar datos del cliente en sesión
            $_SESSION['cliente_nombre'] = $nombre_completo;
            $_SESSION['cliente_email'] = $mail;
            $_SESSION['cliente_telefono'] = $telefono;
            
            // Cerrar statement
            $stmt->close();
            
            // Redirigir a la página de pago
            header("Location: pagar_carrito.php");
            exit();
        } else {
            // Error al ejecutar
            $stmt->close();
            header("Location: prepago.php?error=bd_error");
            exit();
        }
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