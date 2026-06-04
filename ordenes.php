<?php

include("includes/conexion.php");
include("includes/header.php");

$sql = "
SELECT
o.id_orden,
c.nombre,
o.fecha,
o.hora
FROM orden o
INNER JOIN cliente c
ON o.id_cliente = c.id_cliente
";

$ordenes = $conexion->query($sql);

?>

<h1>Órdenes</h1>

<table>

<tr>
<th>ID Orden</th>
<th>Cliente</th>
<th>Fecha</th>
<th>Hora</th>
</tr>

<?php while($o = $ordenes->fetch_assoc()){ ?>

<tr>
<td><?= $o['id_orden'] ?></td>
<td><?= $o['nombre'] ?></td>
<td><?= $o['fecha'] ?></td>
<td><?= $o['hora'] ?></td>
</tr>

<?php } ?>

</table>

<?php include("includes/footer.php"); ?>