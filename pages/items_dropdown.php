<?php
include_once(__DIR__ . "/../conf/conf.php");

$sql = "SELECT id_categoria, nombre_cat FROM categorias ORDER BY nombre_cat ASC";
$res = $conf->query($sql);

if ($res && $res->num_rows > 0) {
  while ($row = $res->fetch_assoc()) {
    if (!isset($row['nombre_cat'], $row['id_categoria'])) {
        continue;
    }
    $nombre = htmlspecialchars($row['nombre_cat'], ENT_QUOTES, 'UTF-8');
    $id = (int)$row['id_categoria'];
    echo "<a href='productos.php?categoria=" . $id . "' class='dropdown-item'>" . $nombre . "</a>";
  }
} else {
  echo "<span class='dropdown-item'>Sin categorías</span>";
}
?>