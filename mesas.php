<?php

include("includes/conexion.php");
include("includes/header.php");

$mesas = $conexion->query("SELECT * FROM mesa");

?>

<h1>Estado de Mesas</h1>

<table>

<tr>
    <th>Mesa</th>
    <th>Capacidad</th>
    <th>Ubicación</th>
    <th>Estado</th>
</tr>

<?php while($m = $mesas->fetch_assoc()){ ?>

<tr>

<td><?= $m['numero_mesa'] ?></td>

<td><?= $m['capacidad'] ?> personas</td>

<td><?= $m['ubicacion'] ?></td>

<td>

<?php

if($m['estado']=="Disponible"){
    echo "<span class='estado disponible'>Disponible</span>";
}
elseif($m['estado']=="Ocupada"){
    echo "<span class='estado ocupada'>Ocupada</span>";
}
else{
    echo "<span class='estado reservada'>Reservada</span>";
}

?>

</td>

</tr>

<?php } ?>

</table>

<?php include("includes/footer.php"); ?>