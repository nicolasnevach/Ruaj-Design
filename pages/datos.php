<?php
include_once("../components/header.php");
include_once("../conf/conf.php"); // Asegurate de tener esto para acceder a la base de datos
?>

<h1>¡El formulario se envió correctamente!</h1>

<?php
// Procesar los datos del formulario
$nombre = $_POST["nombre"] ?? "";
$altura = $_POST["altu"] ?? "";
$profundidad = $_POST["prof"] ?? "";
$ancho = $_POST["ancho"] ?? "";
$comentarios = $_POST["comentarios"] ?? "";
$pintado = isset($_POST["info"]) ? 1 : 0;
$cv = "";

// Mostrar los datos del formulario
print "<p>Gracias por contactarnos. Estaremos creando tu producto: <strong>$nombre</strong></p>";
print "<p><strong>Altura:</strong> $altura cm</p>";
print "<p><strong>Profundidad:</strong> $profundidad cm</p>";
print "<p><strong>Ancho:</strong> $ancho cm</p>";
print "<p><strong>Pintado:</strong> " . ($pintado ? "Sí" : "No") . "</p>";
print "<p><strong>Comentarios:</strong> $comentarios</p>";

// Procesar el archivo subido si existe
if (isset($_FILES["cv"]) && $_FILES["cv"]["error"] == 0) {
    $cv = time() . "_" . basename($_FILES["cv"]["name"]);
    
    if (!file_exists("../archivos")) {
        mkdir("../archivos", 0777, true);
    }

    $rutaFinal = "../archivos/" . $cv;

    if (move_uploaded_file($_FILES["cv"]["tmp_name"], $rutaFinal)) {
        print "<p>¡Tu imagen fue subida correctamente!</p>";
        print "<div><strong>Vista previa de la imagen:</strong><br>";
        print "<img src='$rutaFinal' alt='Imagen enviada' style='max-width:300px; margin-top:10px;'></div>";
    } else {
        print "<p>Ha ocurrido un error al subir la imagen.</p>";
    }
} else {
    print "<p>No se cargó ninguna imagen.</p>";
}

// GUARDAR EN LA BASE DE DATOS
$sql = "INSERT INTO pedidos (nombre, altura, ancho, profundidad, imagen, pintado, comentarios) 
        VALUES ('$nombre', '$altura', '$ancho', '$profundidad', '$cv', '$pintado', '$comentarios')";

$resultado = mysqli_query($conf, $sql);

if ($resultado) {
    print "<p>Tu solicitud fue registrada correctamente en nuestra base de datos.</p>";
} else {
    print "<p>Error al guardar en la base de datos: " . mysqli_error($conf) . "</p>";
}
?>

<div class="text-center mt-4">
    <a href="inicio.php" class="btn btn-outline-success">Volver al inicio</a>
</div>

<?php
include_once("../components/footer.php");
?>
