<?php

include("includes/proteger.php");
include("includes/conexion.php");

$idOrden = (int) ($_GET["id"] ?? 0);

if ($idOrden <= 0) {
    header(
        "Location: ordenes.php?error=" .
        urlencode("La orden seleccionada no es válida.")
    );
    exit();
}

/* Consultar orden */

$sqlOrden = "
    SELECT
        o.id_orden,
        o.estado,
        o.total,
        c.nombre AS cliente,
        m.numero_mesa
    FROM orden o
    INNER JOIN cliente c
        ON o.id_cliente = c.id_cliente
    INNER JOIN mesa m
        ON o.id_mesa = m.id_mesa
    WHERE o.id_orden = ?
    LIMIT 1
";

$consultaOrden = $conexion->prepare($sqlOrden);
$consultaOrden->bind_param("i", $idOrden);
$consultaOrden->execute();

$resultadoOrden = $consultaOrden->get_result();

if ($resultadoOrden->num_rows !== 1) {
    header(
        "Location: ordenes.php?error=" .
        urlencode("La orden seleccionada no existe.")
    );
    exit();
}

$orden = $resultadoOrden->fetch_assoc();

if ($orden["estado"] !== "Abierta") {
    header(
        "Location: detalle_orden.php?id=" .
        $idOrden .
        "&error=" .
        urlencode("No se pueden agregar platillos a una orden cerrada o cancelada.")
    );
    exit();
}

/* Obtener menú */

$menu = $conexion->query("
    SELECT
        menu_item_id,
        item_name,
        category,
        price
    FROM menu_items
    ORDER BY category, item_name
");

$error = trim($_GET["error"] ?? "");

include("includes/header.php");
?>

<div class="encabezado-pagina">

    <div>
        <h1>Agregar platillo</h1>

        <p>
            Orden #<?= $idOrden ?> ·
            <?= htmlspecialchars($orden["cliente"]) ?> ·
            Mesa <?= (int) $orden["numero_mesa"] ?>
        </p>
    </div>

    <a
        href="ordenes.php"
        class="boton boton-secundario"
    >
        Volver
    </a>

</div>

<?php if ($error !== "") { ?>

    <div class="alerta error">
        <?= htmlspecialchars($error) ?>
    </div>

<?php } ?>

<div class="formulario-card">

    <form
        action="guardar_platillo_orden.php"
        method="POST"
    >

        <input
            type="hidden"
            name="id_orden"
            value="<?= $idOrden ?>"
        >

        <div class="form-grid">

            <div class="campo campo-completo">

                <label for="item_id">
                    Platillo
                </label>

                <select
                    id="item_id"
                    name="item_id"
                    required
                >

                    <option value="">
                        Selecciona un platillo
                    </option>

                    <?php while ($producto = $menu->fetch_assoc()) { ?>

                        <option
                            value="<?= (int) $producto["menu_item_id"] ?>"
                            data-precio="<?= $producto["price"] ?>"
                        >
                            <?= htmlspecialchars($producto["item_name"]) ?>
                            —
                            <?= htmlspecialchars($producto["category"]) ?>
                            —
                            $<?= number_format(
                                (float) $producto["price"],
                                2
                            ) ?>
                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="campo">

                <label for="cantidad">
                    Cantidad
                </label>

                <input
                    type="number"
                    id="cantidad"
                    name="cantidad"
                    min="1"
                    max="20"
                    value="1"
                    required
                >

            </div>

            <div class="campo">

                <label>
                    Subtotal estimado
                </label>

                <div
                    id="subtotal-estimado"
                    class="subtotal-estimado"
                >
                    $0.00
                </div>

            </div>

        </div>

        <div class="form-acciones">

            <button
                type="submit"
                class="boton boton-principal"
            >
                Agregar a la orden
            </button>

            <a
                href="detalle_orden.php?id=<?= $idOrden ?>"
                class="boton boton-secundario"
            >
                Ver detalle
            </a>

        </div>

    </form>

</div>

<script>
const selectorProducto = document.getElementById("item_id");
const campoCantidad = document.getElementById("cantidad");
const subtotal = document.getElementById("subtotal-estimado");

function actualizarSubtotal() {

    const opcion =
        selectorProducto.options[selectorProducto.selectedIndex];

    const precio =
        Number(opcion?.dataset?.precio || 0);

    const cantidad =
        Number(campoCantidad.value || 0);

    subtotal.textContent =
        "$" + (precio * cantidad).toFixed(2);
}

selectorProducto.addEventListener(
    "change",
    actualizarSubtotal
);

campoCantidad.addEventListener(
    "input",
    actualizarSubtotal
);
</script>

<?php include("includes/footer.php"); ?>