<?php
include("includes/proteger.php");
?>

<?php

include("includes/conexion.php");
include("includes/header.php");

$clientes = $conexion->query("SELECT * FROM cliente");

?>

<h1>Clientes</h1>

<input
type="text"
id="buscar"
placeholder="Buscar cliente..."
onkeyup="filtrar()"
>

<table id="tabla">

<tr>
<th>ID</th>
<th>Nombre</th>
<th>Teléfono</th>
<th>Correo</th>
</tr>

<?php while($c = $clientes->fetch_assoc()){ ?>

<tr>
<td><?= $c['id_cliente'] ?></td>
<td><?= $c['nombre'] ?></td>
<td><?= $c['telefono'] ?></td>
<td><?= $c['correo'] ?></td>
</tr>

<?php } ?>

</table>

<script>

function filtrar(){

let input =
document.getElementById("buscar").value.toLowerCase();

let filas =
document.querySelectorAll("#tabla tr");

filas.forEach((fila,index)=>{

if(index===0) return;

let texto =
fila.textContent.toLowerCase();

fila.style.display =
texto.includes(input) ? "" : "none";

});

}

</script>

<?php include("includes/footer.php"); ?>
