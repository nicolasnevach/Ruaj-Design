<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contacto.php");
    exit();
}

include_once("../components/header.php");
include_once("../conf/conf.php");

$nombre      = htmlspecialchars(trim($_POST["nombre_apellido"] ?? ""), ENT_QUOTES, 'UTF-8');
$mail        = htmlspecialchars(trim($_POST["email"] ?? ""), ENT_QUOTES, 'UTF-8');
$telefono    = htmlspecialchars(trim($_POST["telefono"] ?? ""), ENT_QUOTES, 'UTF-8');
$producto    = htmlspecialchars(trim($_POST["nombre_producto"] ?? ""), ENT_QUOTES, 'UTF-8');
$altura      = ($_POST["altu"] ?? "") !== "" ? (int)$_POST["altu"] : null;
$ancho       = ($_POST["ancho"] ?? "") !== "" ? (int)$_POST["ancho"] : null;
$profundidad = ($_POST["prof"] ?? "") !== "" ? (int)$_POST["prof"] : null;
$comentarios = htmlspecialchars(trim($_POST["comentarios"] ?? ""), ENT_QUOTES, 'UTF-8');
$pintado     = isset($_POST["info"]) ? 1 : 0;
$cv          = "";
$fecha       = date("Y-m-d H:i:s");

$errores = [];
if ($nombre === "") $errores[] = "El nombre es obligatorio.";
if ($producto === "") $errores[] = "El nombre del producto es obligatorio.";
if ($mail === "" || !filter_var($mail, FILTER_VALIDATE_EMAIL)) $errores[] = "El email es inválido.";
if ($telefono === "") $errores[] = "El teléfono es obligatorio.";
if (strlen($nombre) > 100 || strlen($mail) > 100 || strlen($telefono) > 20) $errores[] = "Algunos campos son demasiado largos.";

if (!empty($errores)) {
    echo "<div class='alert alert-danger'><ul>";
    foreach ($errores as $error) echo "<li>$error</li>";
    echo "</ul></div>";
    echo "<a href='contacto.php' class='btn btn-primary'>Volver al formulario</a>";
    include_once("../components/footer.php");
    exit();
}

echo "<div class='container mt-4'>";
echo "<div class='alert alert-success'>";
echo "<h4>¡Gracias por contactarnos, <strong>$nombre</strong>!</h4>";
echo "<p>Nos comunicaremos vía mail para avisarte sobre tu pedido de: <strong>$producto</strong></p>";
echo "</div>";

echo "<div class='card'><div class='card-body'>";
echo "<h5>Detalles del pedido:</h5>";
echo "<p><strong>Altura:</strong> " . ($altura ? $altura . " cm" : "No especificada") . "</p>";
echo "<p><strong>Ancho:</strong> " . ($ancho ? $ancho . " cm" : "No especificado") . "</p>";
echo "<p><strong>Profundidad:</strong> " . ($profundidad ? $profundidad . " cm" : "No especificada") . "</p>";
echo "<p><strong>Pintado:</strong> " . ($pintado ? "Sí" : "No") . "</p>";
if ($comentarios !== "") echo "<p><strong>Comentarios:</strong> $comentarios</p>";
echo "</div></div>";

if (!empty($_FILES["cv"]) && $_FILES["cv"]["error"] === UPLOAD_ERR_OK) {
    $tamano_max = 5 * 1024 * 1024;
    if ($_FILES["cv"]["size"] <= $tamano_max) {
        $ext_permitidas = ["jpg", "jpeg", "png", "gif", "webp"];
        $extension = strtolower(pathinfo($_FILES["cv"]["name"], PATHINFO_EXTENSION));

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $_FILES["cv"]["tmp_name"]);
        finfo_close($finfo);

        $mimes_permitidos = ["image/jpeg", "image/png", "image/gif", "image/webp"];

        if (in_array($extension, $ext_permitidas) && in_array($mime, $mimes_permitidos)) {
            $dir = "../archivos";
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            $cv = date("Ymd_His") . "_" . uniqid() . "." . $extension;
            $rutaFinal = $dir . "/" . $cv;

            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $rutaFinal)) {
                echo "<div class='alert alert-success mt-3'>¡Tu imagen fue subida correctamente!</div>";
                echo "<div class='text-center mt-3'>";
                echo "<strong>Vista previa:</strong><br>";
                echo "<img src='$rutaFinal' alt='Imagen enviada' class='img-thumbnail' style='max-width:300px; margin-top:10px;'>";
                echo "</div>";
            } else {
                $cv = "";
                echo "<div class='alert alert-danger mt-3'>Error al subir la imagen.</div>";
            }
        } else {
            echo "<div class='alert alert-danger mt-3'>Tipo de archivo no permitido. Solo JPG, PNG, GIF o WEBP.</div>";
        }
    } else {
        echo "<div class='alert alert-danger mt-3'>El archivo es demasiado grande. Máximo 5MB.</div>";
    }
} elseif (!empty($_FILES["cv"]) && $_FILES["cv"]["error"] !== UPLOAD_ERR_NO_FILE) {
    echo "<div class='alert alert-warning mt-3'>Error al subir el archivo. Código: " . $_FILES["cv"]["error"] . "</div>";
}

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
    error_log("Error BD en datos.php: " . $stmt->error);
    echo "<div class='alert alert-danger mt-3'>Error al guardar la solicitud. Por favor, inténtalo más tarde.</div>";
}

$stmt->close();
$conf->close();


$mensaje_admin = "
Nuevo pedido desde el formulario de contacto:

Nombre: $nombre
Email: $mail
Teléfono: $telefono

Producto solicitado: $producto
Altura: " . ($altura ? $altura . " cm" : "No especificada") . "
Ancho: " . ($ancho ? $ancho . " cm" : "No especificado") . "
Profundidad: " . ($profundidad ? $profundidad . " cm" : "No especificada") . "

Pintado: " . ($pintado ? "Sí" : "No") . "
Comentarios: $comentarios

Imagen: " . ($cv !== "" ? "Guardada en /archivos/$cv" : "No se subió") . "

Fecha: $fecha
";

$headers_admin  = "From: Notificaciones RUAJ <no-reply@ruajdesign.com.ar>\r\n";
$headers_admin .= "Reply-To: $mail\r\n";

mail("ruajdesign@gmail.com", "Nuevo pedido de formulario - $nombre", $mensaje_admin, $headers_admin);

?>

</div>

<div class="text-center mt-4 mb-5">
    <a href="inicio.php" class="btn btn-success">Volver al inicio</a>
    <a href="contacto.php" class="btn btn-outline-secondary">Hacer otro pedido</a>
</div>

<?php include_once("../components/footer.php"); ?>
