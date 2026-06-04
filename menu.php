<?php

include("includes/conexion.php");
include("includes/header.php");

$menu = $conexion->query(
"SELECT * FROM menu_items"
);

?>

<h1>Menú</h1>

<table>

<tr>
<th>ID</th>
<th>Nombre</th>
<th>Categoría</th>
<th>Precio</th>
</tr>

<?php while($m = $menu->fetch_assoc()){ ?>

<tr>
<td><?= $m['menu_item_id'] ?></td>
<td><?= $m['item_name'] ?></td>
<td><?= $m['category'] ?></td>
<td>$<?= $m['price'] ?></td>
</tr>

<?php } ?>

</table>

<?php include("includes/footer.php"); ?>