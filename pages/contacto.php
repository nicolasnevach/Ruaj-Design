<?php
include_once("../components/header.php");
?>

<h1 class="titu" id="titulo-formulario">¡Contanos sobre tu mueble!</h1>

<div class="card" id="card_con">
  <div class="card-body">
    <form action="datos.php" method="post" enctype="multipart/form-data">

      <!-- Datos personales en 2 columnas -->
      <div class="fila-datos-personales">
        <div>
          <label for="nombre_apellido">Nombre y apellido:</label>
          <input type="text" 
                 name="nombre_apellido" 
                 id="nombre_apellido" 
                 placeholder="Ingrese su nombre y apellido"
                 maxlength="100"
                 required> 
        </div>
        <div>
          <label for="email">Mail:</label>
          <input type="email" 
                 name="email" 
                 id="email" 
                 placeholder="ejemplo@correo.com"
                 maxlength="100"
                 required> 
        </div>
      </div>

      <!-- Nombre del producto -->
      <div class="fila-producto">
        <div>
          <label for="nombre_producto">Nombre del producto:</label>
          <input type="text" 
                 name="nombre_producto" 
                 id="nombre_producto" 
                 placeholder="Ej: Mesa de comedor, Escritorio, etc."
                 maxlength="100"
                 required> 
        </div>
      </div>

      <!-- Dimensiones -->
      <div class="fila-dimensiones">
        <div>
          <label for="altura">Altura (cm):</label>
          <input type="number" 
                 name="altu" 
                 id="altura" 
                 placeholder="Altura"
                 min="1"
                 max="500"
                 step="0.1">
        </div>
        <div>
          <label for="ancho">Ancho (cm):</label>
          <input type="number" 
                 name="ancho" 
                 id="ancho" 
                 placeholder="Ancho"
                 min="1"
                 max="500"
                 step="0.1">
        </div>
        <div>
          <label for="profundidad">Profundidad (cm):</label>
          <input type="number" 
                 name="prof" 
                 id="profundidad" 
                 placeholder="Profundidad"
                 min="1"
                 max="500"
                 step="0.1">
        </div>
      </div>

      <!-- Teléfono -->
      <div class="fila-producto">
        <div>
          <label for="telefono">Teléfono:</label>
          <input type="tel" 
                 name="telefono" 
                 id="telefono" 
                 placeholder="Ej: +54 11 1234-5678"
                 pattern="[0-9+\-\s()]*"
                 title="Ingrese un número de teléfono válido"
                 maxlength="20"
                 required>
        </div>
      </div>

      <!-- Archivo -->
      <div class="fila-archivo">
        <div>
          <label for="imagen">Cargar imagen (opcional):</label>
          <input type="file" 
                 name="cv" 
                 id="imagen" 
                 accept="image/jpeg,image/png,image/jpg,image/webp">
          <small style="display: block; margin-top: 5px; color: #666;">
            Formatos permitidos: JPG, PNG, WEBP. Tamaño máximo: 5MB
          </small>
        </div>
      </div>

      <!-- Checkbox -->
      <div class="fila-checkbox">
        <div class="checkbox-container">
          <input type="checkbox" name="info" id="pintado" value="1">
          <label for="pintado">¿Requiere pintado?</label>
        </div>
      </div>

      <!-- Comentarios -->
      <div class="area-comentarios">
        <label for="comentarios">Comentarios/observaciones:</label>
        <textarea id="comentarios" 
                  name="comentarios" 
                  rows="4" 
                  maxlength="500"
                  placeholder="Escribe cualquier detalle adicional aquí (máximo 500 caracteres)..."></textarea>
      </div>

      <div class="submit-container">
        <input id="env" type="submit" name="submit" value="Enviar"> 
      </div>
    </form>
  </div>
</div>

<script>
// Validación de tamaño de archivo (opcional pero recomendado)
function validarTamanioArchivo(input) {
    const maxSize = 5 * 1024 * 1024; // 5MB
    if (input.files.length > 0) {
        const fileSize = input.files[0].size;
        if (fileSize > maxSize) {
            alert('El archivo es demasiado grande. Tamaño máximo: 5MB');
            input.value = '';
        }
    }
}

// Añadir evento al input de archivo
document.getElementById('imagen').addEventListener('change', function() {
    validarTamanioArchivo(this);
});
</script>

<?php
include_once("../components/footer.php");
?>