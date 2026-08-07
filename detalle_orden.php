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

$sqlOrden = "
    SELECT
        o.id_orden,
        o.id_reservacion,
        o.fecha,
        o.hora,
        o.estado,
        o.total,
        c.nombre AS cliente,
        m.numero_mesa,
        u.nombre AS empleado
    FROM orden o
    INNER JOIN cliente c
        ON o.id_cliente = c.id_cliente
    INNER JOIN mesa m
        ON o.id_mesa = m.id_mesa
    INNER JOIN usuario u
        ON o.id_usuario = u.id_usuario
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

/* Agrupar productos iguales */

$sqlDetalles = "
    SELECT
        mi.menu_item_id,
        mi.item_name,
        mi.category,
        mi.price,
        COUNT(od.order_details_id) AS cantidad,
        SUM(mi.price) AS subtotal
    FROM order_details od
    INNER JOIN menu_items mi
        ON od.item_id = mi.menu_item_id
    WHERE od.order_id = ?
    GROUP BY
        mi.menu_item_id,
        mi.item_name,
        mi.category,
        mi.price
    ORDER BY mi.item_name
";

$consultaDetalles =
    $conexion->prepare($sqlDetalles);

$consultaDetalles->bind_param("i", $idOrden);
$consultaDetalles->execute();

$detalles = $consultaDetalles->get_result();

$mensaje = trim($_GET["mensaje"] ?? "");
$error = trim($_GET["error"] ?? "");

include("includes/header.php");
?>

<div class="encabezado-pagina">

    <div>
        <h1>Detalle de orden #<?= $idOrden ?></h1>

        <p>
            <?= htmlspecialchars($orden["cliente"]) ?> ·
            Mesa <?= (int) $orden["numero_mesa"] ?> ·
            <?= htmlspecialchars($orden["empleado"]) ?>
        </p>
    </div>

    <div class="form-acciones">

        <?php if ($orden["estado"] === "Abierta") { ?>

            <a
                href="agregar_platillos.php?id=<?= $idOrden ?>"
                class="boton boton-principal"
            >
                + Agregar platillos
            </a>

        <?php } ?>

        <a
            href="ordenes.php"
            class="boton boton-secundario"
        >
            Volver
        </a>

    </div>

</div>

<?php if ($mensaje !== "") { ?>

    <div class="alerta exito">
        <?= htmlspecialchars($mensaje) ?>
    </div>

<?php } ?>

<?php if ($error !== "") { ?>

    <div class="alerta error">
        <?= htmlspecialchars($error) ?>
    </div>

<?php } ?>

<div class="datos-orden">

    <div>
        <strong>Reservación:</strong>
        <?= $orden["id_reservacion"] !== null
            ? "#" . (int) $orden["id_reservacion"]
            : "Sin reservación"
        ?>
    </div>

    <div>
        <strong>Fecha:</strong>
        <?= date("d/m/Y", strtotime($orden["fecha"])) ?>
    </div>

    <div>
        <strong>Hora:</strong>
        <?= date("H:i", strtotime($orden["hora"])) ?>
    </div>

    <div>
        <strong>Estado:</strong>

        <span class="estado-orden <?= strtolower($orden["estado"]) ?>">
            <?= htmlspecialchars($orden["estado"]) ?>
        </span>
    </div>

</div>

<div class="tabla-contenedor">

    <table>

        <thead>
            <tr>
                <th>Platillo</th>
                <th>Categoría</th>
                <th>Precio unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>

        <?php if ($detalles->num_rows > 0) { ?>

            <?php while ($detalle = $detalles->fetch_assoc()) { ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($detalle["item_name"]) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($detalle["category"]) ?>
                    </td>

                    <td>
                        $<?= number_format(
                            (float) $detalle["price"],
                            2
                        ) ?>
                    </td>

                    <td>
                        <?= (int) $detalle["cantidad"] ?>
                    </td>

                    <td>
                        $<?= number_format(
                            (float) $detalle["subtotal"],
                            2
                        ) ?>
                    </td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="5" class="sin-registros">
                    Esta orden todavía no tiene platillos.
                </td>
            </tr>

        <?php } ?>

        </tbody>

        <tfoot>
            <tr>
                <th colspan="4">
                    Total de la orden
                </th>

                <th>
                    $<?= number_format(
                        (float) $orden["total"],
                        2
                    ) ?>
                </th>
            </tr>
        </tfoot>

    </table>

</div>

<?php include("includes/footer.php"); ?>