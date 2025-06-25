<?php
include_once("../components/header.php");
?>

<h1 class = "titu" >Contanos sobre tu mueble!</h1>



<div class="card w-50" id="card_con">
  <div class="card-body">
    <form action="datos.php" method="post" enctype="multipart/form-data">
      <label for="nom">Nombre del producto: </label>
      
      <input type="text" name="nombre" id="nom" placeholder="Ingrese el producto"> 
      

      <div class="fila-campos">
        <div>
          <label for="altu">Altura (cm) </label>
          <input class="campo-pequeno" type="text" name="altu" id="altu" placeholder="Altura (cm)">
        </div>
        <div>
          <label for="prof">Profundidad (cm) </label>
          <input class="campo-pequeno" type="text" name="prof" id="prof" placeholder="Profundidad (cm)">
        </div>
        <div>
          <label for="ancho">Ancho (cm) </label>
          <input class="campo-pequeno" type="text" name="ancho" id="ancho" placeholder="Ancho (cm)">
        </div>
      </div>

      

      <label for="cv">Cargar imágen: </label>
      
      <input type="file" name="cv" id="cv">
      
      <div>
        <label for="info">Pintado </label>
        <input type="checkbox" name="info" id="info">
      </div>
      
      <label for="comentarios">Comentarios/observaciones:</label>
      <textarea id="comentarios" name="comentarios" rows="5" cols="40" placeholder="Escribe tu mensaje aquí..."></textarea>

      
      
      <input id="env" type="submit"> 
    </form>
  </div>
</div>


<?php
include_once("../components/footer.php");
?>