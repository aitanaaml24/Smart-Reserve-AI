<?php

include("includes/proteger.php");
include("includes/conexion.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ordenes.php");
    exit();
}

$idOrden = (int) ($_POST["id_orden"] ?? 0);
$itemId = (int) ($_POST["item_id"] ?? 0);
$cantidad = (int) ($_POST["cantidad"] ?? 0);

function regresarConError(
    int $idOrden,
    string $mensaje
): void {

    header(
        "Location: agregar_platillos.php?id=" .
        $idOrden .
        "&error=" .
        urlencode($mensaje)
    );

    exit();
}

if (
    $idOrden <= 0 ||
    $itemId <= 0 ||
    $cantidad <= 0 ||
    $cantidad > 20
) {
    regresarConError(
        $idOrden,
        "Los datos enviados no son válidos."
    );
}

try {

    $conexion->begin_transaction();

    /* Obtener la orden */

    $sqlOrden = "
        SELECT
            fecha,
            hora,
            estado
        FROM orden
        WHERE id_orden = ?
        LIMIT 1
        FOR UPDATE
    ";

    $consultaOrden = $conexion->prepare($sqlOrden);
    $consultaOrden->bind_param("i", $idOrden);
    $consultaOrden->execute();

    $resultadoOrden = $consultaOrden->get_result();

    if ($resultadoOrden->num_rows !== 1) {
        throw new Exception(
            "La orden seleccionada no existe."
        );
    }

    $orden = $resultadoOrden->fetch_assoc();

    if ($orden["estado"] !== "Abierta") {
        throw new Exception(
            "Solo se pueden agregar platillos a órdenes abiertas."
        );
    }

    /* Validar producto */

    $sqlProducto = "
        SELECT price
        FROM menu_items
        WHERE menu_item_id = ?
        LIMIT 1
    ";

    $consultaProducto = $conexion->prepare($sqlProducto);
    $consultaProducto->bind_param("i", $itemId);
    $consultaProducto->execute();

    $resultadoProducto =
        $consultaProducto->get_result();

    if ($resultadoProducto->num_rows !== 1) {
        throw new Exception(
            "El platillo seleccionado no existe."
        );
    }

    /*
     * La tabla original no tiene una columna cantidad.
     * Por eso se agrega una fila por cada unidad solicitada.
     */

    $sqlInsertar = "
        INSERT INTO order_details (
            order_id,
            order_date,
            order_time,
            item_id
        )
        VALUES (?, ?, ?, ?)
    ";

    $consultaInsertar =
        $conexion->prepare($sqlInsertar);

    for ($i = 0; $i < $cantidad; $i++) {

        $consultaInsertar->bind_param(
            "issi",
            $idOrden,
            $orden["fecha"],
            $orden["hora"],
            $itemId
        );

        $consultaInsertar->execute();
    }

    /* Recalcular el total real */

    $sqlTotal = "
        SELECT
            COALESCE(SUM(mi.price), 0) AS total
        FROM order_details od
        INNER JOIN menu_items mi
            ON od.item_id = mi.menu_item_id
        WHERE od.order_id = ?
    ";

    $consultaTotal = $conexion->prepare($sqlTotal);
    $consultaTotal->bind_param("i", $idOrden);
    $consultaTotal->execute();

    $nuevoTotal = (float)
        $consultaTotal
            ->get_result()
            ->fetch_assoc()["total"];

    $sqlActualizarTotal = "
        UPDATE orden
        SET total = ?
        WHERE id_orden = ?
    ";

    $consultaActualizarTotal =
        $conexion->prepare($sqlActualizarTotal);

    $consultaActualizarTotal->bind_param(
        "di",
        $nuevoTotal,
        $idOrden
    );

    $consultaActualizarTotal->execute();

    $conexion->commit();

    header(
        "Location: detalle_orden.php?id=" .
        $idOrden .
        "&mensaje=" .
        urlencode("Platillo agregado correctamente.")
    );

    exit();

} catch (Throwable $error) {

    $conexion->rollback();

    regresarConError(
        $idOrden,
        "No fue posible agregar el platillo: " .
        $error->getMessage()
    );
}