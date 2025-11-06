<?php
// Verificar que sea POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contacto.php");
    exit();
}

include_once("../components/header.php");
include_once("../conf/conf.php");

// --- CAPTURAR Y SANITIZAR DATOS ---
$nombre      = htmlspecialchars(trim($_POST["nombre_apellido"] ?? ""), ENT_QUOTES, 'UTF-8');
$mail        = htmlspecialchars(trim($_POST["email"] ?? ""), ENT_QUOTES, 'UTF-8');
$telefono    = htmlspecialchars(trim($_POST["telefono"] ?? ""), ENT_QUOTES, 'UTF-8');
$producto    = htmlspecialchars(trim($_POST["nombre_producto"] ?? ""), ENT_QUOTES, 'UTF-8');
$altura      = !empty($_POST["altu"]) ? (int)$_POST["altu"] : null;
$ancho       = !empty($_POST["ancho"]) ? (int)$_POST["ancho"] : null;
$profundidad = !empty($_POST["prof"]) ? (int)$_POST["prof"] : null;
$comentarios = htmlspecialchars(trim($_POST["comentarios"] ?? ""), ENT_QUOTES, 'UTF-8');
$pintado     = isset($_POST["info"]) ? 1 : 0;
$cv          = "";
$fecha       = date("Y-m-d H:i:s");

// --- VALIDACIONES ---
$errores = [];

if (empty($nombre)) {
    $errores[] = "El nombre es obligatorio.";
}

if (empty($mail) || !filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El email es inválido.";
}

if (empty($telefono)) {
    $errores[] = "El teléfono es obligatorio.";
}

if (empty($producto)) {
    $errores[] = "El nombre del producto es obligatorio.";
}

// Validar longitud
if (strlen($nombre) > 100 || strlen($mail) > 100 || strlen($telefono) > 20) {
    $errores[] = "Algunos campos son demasiado largos.";
}

// Si hay errores, mostrarlos y detener
if (!empty($errores)) {
    echo "<div class='alert alert-danger'><ul>";
    foreach ($errores as $error) {
        echo "<li>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</li>";
    }
    echo "</ul></div>";
    echo "<a href='contacto.php' class='btn btn-primary'>Volver al formulario</a>";
    include_once("../components/footer.php");
    exit();
}

// --- MOSTRAR DATOS AL USUARIO ---
echo "<div class='container mt-4'>";
echo "<div class='alert alert-success'>";
echo "<h4>¡Gracias por contactarnos, <strong>" . $nombre . "</strong>!</h4>";
echo "<p>Nos comunicaremos vía mail para avisarte sobre tu pedido de: <strong>" . $producto . "</strong></p>";
echo "</div>";

echo "<div class='card'><div class='card-body'>";
echo "<h5>Detalles del pedido:</h5>";
echo "<p><strong>Altura:</strong> " . ($altura ? $altura . " cm" : "No especificada") . "</p>";
echo "<p><strong>Ancho:</strong> " . ($ancho ? $ancho . " cm" : "No especificado") . "</p>";
echo "<p><strong>Profundidad:</strong> " . ($profundidad ? $profundidad . " cm" : "No especificada") . "</p>";
echo "<p><strong>Pintado:</strong> " . ($pintado ? "Sí" : "No") . "</p>";

if (!empty($comentarios)) {
    echo "<p><strong>Comentarios:</strong> " . $comentarios . "</p>";
}
echo "</div></div>";

// --- PROCESAR ARCHIVO SUBIDO ---
if (isset($_FILES["cv"]) && $_FILES["cv"]["error"] === UPLOAD_ERR_OK) {

    // Validar tamaño (máximo 5MB)
    $tamano_max = 5 * 1024 * 1024; // 5MB
    if ($_FILES["cv"]["size"] > $tamano_max) {
        echo "<div class='alert alert-danger mt-3'>El archivo es demasiado grande. Máximo 5MB.</div>";
    } else {
        
        // Validar extensión
        $ext_permitidas = ["jpg", "jpeg", "png", "gif", "webp"];
        $extension = strtolower(pathinfo($_FILES["cv"]["name"], PATHINFO_EXTENSION));

        // Validar tipo MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES["cv"]["tmp_name"]);
        finfo_close($finfo);
        
        $mimes_permitidos = ["image/jpeg", "image/png", "image/gif", "image/webp"];

        if (in_array($extension, $ext_permitidas) && in_array($mime, $mimes_permitidos)) {
            
            // Crear nombre único y seguro
            $cv = date("Ymd_His") . "_" . uniqid() . "." . $extension;

            // Crear directorio si no existe
            if (!file_exists("../archivos")) {
                mkdir("../archivos", 0755, true);
            }

            $rutaFinal = "../archivos/" . $cv;

            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $rutaFinal)) {
                echo "<div class='alert alert-success mt-3'>¡Tu imagen fue subida correctamente!</div>";
                echo "<div class='text-center mt-3'>";
                echo "<strong>Vista previa:</strong><br>";
                echo "<img src='" . htmlspecialchars($rutaFinal, ENT_QUOTES, 'UTF-8') . "' alt='Imagen enviada' class='img-thumbnail' style='max-width:300px; margin-top:10px;'>";
                echo "</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Error al subir la imagen.</div>";
                $cv = ""; // No guardar nombre si falló
            }
        } else {
            echo "<div class='alert alert-danger mt-3'>Tipo de archivo no permitido. Solo JPG, PNG, GIF o WEBP.</div>";
        }
    }
} else if (isset($_FILES["cv"]) && $_FILES["cv"]["error"] !== UPLOAD_ERR_NO_FILE) {
    echo "<div class='alert alert-warning mt-3'>Error al subir el archivo. Código: " . $_FILES["cv"]["error"] . "</div>";
}

// --- GUARDAR EN LA BASE DE DATOS ---
$stmt = $conf->prepare("INSERT INTO pedidos 
    (nombre, mail, telefono, producto, altura, ancho, profundidad, imagen, pintado, comentarios, fecha) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "ssssiiisiss",
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
    echo "<div class='alert alert-success mt-3'>Tu solicitud fue registrada correctamente.</div>";
} else {
    // Registrar error en log (no mostrarlo al usuario)
    error_log("Error BD en datos.php: " . $stmt->error);
    echo "<div class='alert alert-danger mt-3'>Error al guardar la solicitud. Por favor, inténtalo más tarde.</div>";
}

$stmt->close();
$conf->close();
?>

<div class="text-center mt-4 mb-5">
    <a href="inicio.php" class="btn btn-success">Volver al inicio</a>
    <a href="contacto.php" class="btn btn-outline-secondary">Hacer otro pedido</a>
</div>

</div>

<?php
include_once("../components/footer.php");
?>