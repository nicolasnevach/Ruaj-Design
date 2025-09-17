<?php
include_once("../components/header.php");
include_once("../conf/conf.php"); // conexión a la base de datos
?>

<h1>¡El formulario se envió correctamente!</h1>

<?php
// --- CAPTURAR DATOS DEL FORMULARIO ---
$nombre     = $_POST["nombre_apellido"] ?? "";
$mail       = $_POST["email"] ?? "";
$telefono   = $_POST["telefono"] ?? "";
$producto   = $_POST["nombre_producto"] ?? "";
$altura     = $_POST["altu"] ?? "";
$profundidad= $_POST["prof"] ?? "";
$ancho      = $_POST["ancho"] ?? "";
$comentarios= $_POST["comentarios"] ?? "";
$pintado    = isset($_POST["info"]) ? 1 : 0;
$cv         = ""; // nombre final del archivo
$fecha      = date("Y-m-d H:i:s"); // fecha y hora actual para la columna 'fecha'

// --- MOSTRAR DATOS AL USUARIO ---
print "<p>Gracias por contactarnos, <strong>$nombre</strong></p>";
print "<p>Nos comunicaremos via mail para avisarte sobre tu pedido de:<strong> $producto</strong></p>";
print "<p><strong>Altura:</strong> $altura cm</p>";
print "<p><strong>Ancho:</strong> $ancho cm</p>";
print "<p><strong>Profundidad:</strong> $profundidad cm</p>";
print "<p><strong>Pintado:</strong> " . ($pintado ? "Sí" : "No") . "</p>";
print "<p><strong>Comentarios:</strong> $comentarios</p>";

// --- PROCESAR ARCHIVO SUBIDO ---
if (isset($_FILES["cv"]) && $_FILES["cv"]["error"] == 0) {

    // Lista de extensiones permitidas
    $ext_permitidas = ["jpg", "jpeg", "png", "gif", "webp"];
    $extension = strtolower(pathinfo($_FILES["cv"]["name"], PATHINFO_EXTENSION));

    if (in_array($extension, $ext_permitidas)) {
        // Generar nombre único: fecha + hora + microsegundos + extensión
        $cv = date("Ymd_His") . "_" . uniqid() . "." . $extension;

        // Crear carpeta si no existe
        if (!file_exists("../archivos")) {
            mkdir("../archivos", 0777, true);
        }

        $rutaFinal = "../archivos/" . $cv;

        if (move_uploaded_file($_FILES["cv"]["tmp_name"], $rutaFinal)) {
            print "<p>¡Tu imagen fue subida correctamente!</p>";
            print "<div><strong>Vista previa de la imagen:</strong><br>";
            print "<img src='$rutaFinal' alt='Imagen enviada' style='max-width:300px; margin-top:10px;'></div>";
        } else {
            print "<p style='color:red;'>Ha ocurrido un error al subir la imagen.</p>";
        }
    } else {
        print "<p style='color:red;'>Tipo de archivo no permitido. Solo se aceptan JPG, PNG, GIF o WEBP.</p>";
    }

} else {
    print "<p>No se cargó ninguna imagen.</p>";
}

// --- GUARDAR EN LA BASE DE DATOS ---
$sql = "INSERT INTO pedidos (nombre, mail, telefono, producto, altura, ancho, profundidad, imagen, pintado, comentarios, fecha) 
        VALUES ('$nombre', '$mail', '$telefono', '$producto', '$altura', '$ancho', '$profundidad', '$cv', '$pintado', '$comentarios', '$fecha')";

$resultado = mysqli_query($conf, $sql);

if ($resultado) {
    print "<p>Tu solicitud fue registrada correctamente en nuestra base de datos.</p>";
} else {
    print "<p style='color:red;'>Error al guardar en la base de datos: " . mysqli_error($conf) . "</p>";
}
?>

<div class="text-center mt-4">
    <a href="inicio.php" class="btn btn-outline-success">Volver al inicio</a>
</div>

<?php
include_once("../components/footer.php");
?>
