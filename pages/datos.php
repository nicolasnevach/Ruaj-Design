<?php
include_once("../components/header.php");
include_once("../conf/conf.php"); // conexión a la base de datos

// --- CAPTURAR DATOS DEL FORMULARIO ---
$nombre      = $_POST["nombre_apellido"] ?? "";
$mail        = $_POST["email"] ?? "";
$telefono    = $_POST["telefono"] ?? "";
$producto    = $_POST["nombre_producto"] ?? "";
$altura      = $_POST["altu"] ?? "";
$profundidad = $_POST["prof"] ?? "";
$ancho       = $_POST["ancho"] ?? "";
$comentarios = $_POST["comentarios"] ?? "";
$pintado     = isset($_POST["info"]) ? 1 : 0;
$cv          = "";
$fecha       = date("Y-m-d H:i:s");

// --- MOSTRAR DATOS AL USUARIO (protegido con htmlspecialchars) ---
echo "<p>Gracias por contactarnos, <strong>" . htmlspecialchars($nombre) . "</strong></p>";
echo "<p>Nos comunicaremos via mail para avisarte sobre tu pedido de:<strong> " . htmlspecialchars($producto) . "</strong></p>";
echo "<p><strong>Altura:</strong> " . htmlspecialchars($altura) . " cm</p>";
echo "<p><strong>Ancho:</strong> " . htmlspecialchars($ancho) . " cm</p>";
echo "<p><strong>Profundidad:</strong> " . htmlspecialchars($profundidad) . " cm</p>";
echo "<p><strong>Pintado:</strong> " . ($pintado ? "Sí" : "No") . "</p>";
echo "<p><strong>Comentarios:</strong> " . htmlspecialchars($comentarios) . "</p>";

// --- PROCESAR ARCHIVO SUBIDO ---
if (isset($_FILES["cv"]) && $_FILES["cv"]["error"] === 0) {

    $ext_permitidas = ["jpg", "jpeg", "png", "gif", "webp"];
    $extension = strtolower(pathinfo($_FILES["cv"]["name"], PATHINFO_EXTENSION));

    if (in_array($extension, $ext_permitidas)) {
        $cv = date("Ymd_His") . "_" . uniqid() . "." . $extension;

        if (!file_exists("../archivos")) {
            mkdir("../archivos", 0777, true);
        }

        $rutaFinal = "../archivos/" . $cv;

        if (move_uploaded_file($_FILES["cv"]["tmp_name"], $rutaFinal)) {
            echo "<p>¡Tu imagen fue subida correctamente!</p>";
            echo "<div><strong>Vista previa de la imagen:</strong><br>";
            echo "<img src='" . htmlspecialchars($rutaFinal) . "' alt='Imagen enviada' style='max-width:300px; margin-top:10px;'></div>";
        } else {
            echo "<p style='color:red;'>Ha ocurrido un error al subir la imagen.</p>";
        }
    } else {
        echo "<p style='color:red;'>Tipo de archivo no permitido. Solo se aceptan JPG, PNG, GIF o WEBP.</p>";
    }

} else {
    echo "<p>No se cargó ninguna imagen.</p>";
}

// --- GUARDAR EN LA BASE DE DATOS con prepared statement ---
$stmt = $conf->prepare("INSERT INTO pedidos 
    (nombre, mail, telefono, producto, altura, ancho, profundidad, imagen, pintado, comentarios, fecha) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "ssssiiisis",
    $nombre,
    $mail,
    $telefono,
    $producto,
    $altura,
    $ancho,
    $profundidad,
    $cv,
    $pintado,
    $comentarios,
    $fecha
);

if ($stmt->execute()) {
    echo "<p>Tu solicitud fue registrada correctamente en nuestra base de datos.</p>";
} else {
    echo "<p style='color:red;'>Error al guardar en la base de datos: " . htmlspecialchars($stmt->error) . "</p>";
}

$stmt->close();
?>

<div class="text-center mt-4">
    <a href="inicio.php" class="btn btn-outline-success">Volver al inicio</a>
</div>

<?php
include_once("../components/footer.php");
?>
