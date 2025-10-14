<?php
include_once(__DIR__ . "/../conf/conf.php");

$sql = "SELECT id_categoria, nombre_cat FROM categorias ORDER BY nombre_cat ASC";
$res = $conf->query($sql);

if ($res && $res->num_rows > 0) {
  while ($row = $res->fetch_assoc()) {
    $nombre = $row['nombre_cat'];
    $id = (int)$row['id_categoria']; // Aseguramos que sea un entero
    print "<a href='productos.php?categoria=$id' class='dropdown-item'>$nombre</a>";
  }
} else {
  print "<span class='dropdown-item'>Sin categorías</span>";
}
?>
