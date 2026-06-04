<?php

include("includes/conexion.php");
include("includes/header.php");

$clientes = $conexion->query(
"SELECT COUNT(*) total FROM cliente"
)->fetch_assoc()['total'];

$productos = $conexion->query(
"SELECT COUNT(*) total FROM menu_items"
)->fetch_assoc()['total'];

$ordenes = $conexion->query(
"SELECT COUNT(*) total FROM orden"
)->fetch_assoc()['total'];

?>

<h1>Dashboard</h1>

<div class="cards">

<div class="card">
<h3>Clientes</h3>
<h2><?php echo $clientes; ?></h2>
</div>

<div class="card">
<h3>Productos</h3>
<h2><?php echo $productos; ?></h2>
</div>

<div class="card">
<h3>Órdenes</h3>
<h2><?php echo $ordenes; ?></h2>
</div>

</div>

<?php include("includes/footer.php"); ?>