<?php
include_once("../components/header.php");
?>

<h1 class="titu" id="titulo-formulario">¡Contanos sobre tu mueble!</h1>

<div class="card" id="card_con">
  <div class="card-body">
    <form action="datos.php" method="post" enctype="multipart/form-data">

      <!-- Datos personales en 2 columnas -->
      <!-- Datos personales en 2 columnas -->
<div class="fila-datos-personales">
  <div>
    <label for="nom">Nombre y apellido:</label>
    <input type="text" name="nombre_apellido" id="nom" placeholder="Ingrese su nombre y apellido"> 
  </div>
  <div>
    <label for="mail">Mail:</label>
    <input type="email" name="email" id="mail" placeholder="Ingrese su email"> 
  </div>
</div>

<!-- Nombre del producto en su propia fila -->
<div class="fila-producto">
  <div>
    <label for="nombre_prod">Nombre del producto:</label>
    <input type="text" name="nombre_producto" id="nombre_prod" placeholder="Ingrese el producto"> 
  </div>
</div>

<!-- Dimensiones en 3 columnas -->
<div class="fila-dimensiones">
  <div>
    <label for="altu">Altura (cm):</label>
    <input type="number" name="altu" id="altu" placeholder="Altura">
  </div>
  <div>
    <label for="ancho">Ancho (cm):</label>
    <input type="number" name="ancho" id="ancho" placeholder="Ancho">
  </div>
  <div>
    <label for="prof">Profundidad (cm):</label>
    <input type="number" name="prof" id="prof" placeholder="Profundidad">
  </div>
</div>

<!-- Teléfono en fila completa -->
<div style="margin-bottom: 15px;">
  <label for="tel">Teléfono:</label>
  <input type="number" name="telefono" id="tel" placeholder="Ingrese su teléfono"> 
</div>

<!-- Archivo en su propia fila -->
<div class="fila-archivo">
  <div>
    <label for="cv">Cargar imagen:</label>
    <input type="file" name="cv" id="cv">
  </div>
</div>

<!-- Checkbox en su propia fila -->
<div class="fila-checkbox">
  <div class="checkbox-container">
    <input type="checkbox" name="info" id="info">
    <label for="info">Pintado</label>
  </div>
</div>

<!-- Comentarios en área completa -->
<div class="area-comentarios">
  <label for="comentarios">Comentarios/observaciones:</label>
  <textarea id="comentarios" name="comentarios" rows="2" placeholder="Escribe tu mensaje aquí..."></textarea>
</div>

      <div class="submit-container">
        <input id="env" type="submit" value="Enviar"> 
      </div>
    </form>
  </div>
</div>

<?php
include_once("../components/footer.php");
?>