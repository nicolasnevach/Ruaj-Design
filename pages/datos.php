<?php
include_once("../components/header.php");
?>

<h1>Inicio de sesión exitoso!</h1>

<?php
// Procesar los datos del formulario
$nombre = "";
$cv = "";

if(isset($_POST["nombre"])) {
    $nombre = $_POST["nombre"];
    echo "<p>Gracias por iniciar sesión, $nombre!</p>";
    echo "<p>En breve recibirás un correo con información adicional.</p>";
}

// Procesar el archivo subido si existe
if(isset($_FILES["cv"]) && $_FILES["cv"]["error"] == 0) {
    // Generar un nombre único para el archivo
    $cv = time() . "_" . $_FILES["cv"]["name"];
    
    // Verificar que la carpeta archivos existe, si no, crearla
    if (!file_exists("../archivos")) {
        mkdir("../archivos", 0777, true);
    }
    
    // Mover el archivo subido a la carpeta archivos
    if(move_uploaded_file($_FILES["cv"]["tmp_name"], "../archivos/" . $cv)) {
        echo "<p>¡CV subido correctamente!</p>";
    } else {
        echo "<p>Ha ocurrido un error al subir el archivo.</p>";
    }
}
?>

<div class="text-center mt-4">
    <a href="inicio.php" class="btn btn-outline-success">Volver al inicio</a>
</div>

<?php
include_once("../components/footer.php");
?>