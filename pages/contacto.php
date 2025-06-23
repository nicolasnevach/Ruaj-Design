<?php
include_once("../components/header.php");
?>

<h1 class = "titu" >Iniciar Sesión</h1>

<br>

<div class="card w-50" id="card_con">
  <div class="card-body">
    <form action="datos.php" method="post" enctype="multipart/form-data">
      <label for="nom">Nombre del producto: </label>
      <br>
      <input type="text" name="nombre" id="nom" placeholder="Ingrese el producto"> 
      <br><br>

      <div class="fila-campos">
        <div>
          <label for="altu">Altura (cm) </label><br>
          <input class="campo-pequeno" type="text" name="altu" id="altu" placeholder="Altura (cm)">
        </div>
        <div>
          <label for="prof">Profundidad (cm) </label><br>
          <input class="campo-pequeno" type="text" name="prof" id="prof" placeholder="Profundidad (cm)">
        </div>
        <div>
          <label for="ancho">Ancho (cm) </label><br>
          <input class="campo-pequeno" type="text" name="ancho" id="ancho" placeholder="Ancho (cm)">
        </div>
      </div>

      <br>

      <label for="cv">Cargar imágen: </label>
      <br>
      <input type="file" name="cv" id="cv">
      <br><br>

      <label for="info">Pintado </label>
      <input type="checkbox" name="info" id="info">
      <br><br>
      
      <label for="comentarios">Comentarios:</label><br>
      <textarea id="comentarios" name="comentarios" rows="5" cols="40" placeholder="Escribe tu mensaje aquí..."></textarea>

      <br><br>
      
      <input id="env" type="submit"> 
    </form>
  </div>
</div>


<?php
include_once("../components/footer.php");
?>