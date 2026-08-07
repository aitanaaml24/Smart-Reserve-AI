<?php

include("includes/proteger.php");
include("includes/conexion.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: mesas.php");
    exit();
}

$idMesa = (int) ($_POST["id_mesa"] ?? 0);
$estado = trim($_POST["estado"] ?? "");

$estadosPermitidos = [
    "Disponible",
    "Reservada",
    "Ocupada"
];

if (
    $idMesa <= 0 ||
    !in_array($estado, $estadosPermitidos, true)
) {
    header(
        "Location: mesas.php?error=" .
        urlencode("Los datos enviados no son válidos.")
    );
    exit();
}

/* Verificar que la mesa exista */

$sqlMesa = "
    SELECT id_mesa
    FROM mesa
    WHERE id_mesa = ?
    LIMIT 1
";

$consultaMesa = $conexion->prepare($sqlMesa);
$consultaMesa->bind_param("i", $idMesa);
$consultaMesa->execute();

$resultadoMesa = $consultaMesa->get_result();

if ($resultadoMesa->num_rows !== 1) {
    header(
        "Location: mesas.php?error=" .
        urlencode("La mesa seleccionada no existe.")
    );
    exit();
}

/*
 * Evitar marcar como Disponible una mesa
 * que tenga reservaciones activas.
 */

if ($estado === "Disponible") {

    $sqlActivas = "
        SELECT COUNT(*) AS total
        FROM reservacion
        WHERE id_mesa = ?
          AND estado IN ('Pendiente', 'Confirmada')
    ";

    $consultaActivas = $conexion->prepare($sqlActivas);
    $consultaActivas->bind_param("i", $idMesa);
    $consultaActivas->execute();

    $resultadoActivas = $consultaActivas->get_result();
    $totalActivas = (int) $resultadoActivas->fetch_assoc()["total"];

    if ($totalActivas > 0) {
        header(
            "Location: mesas.php?error=" .
            urlencode(
                "La mesa no puede marcarse como disponible porque tiene una reservación activa."
            )
        );
        exit();
    }
}

/* Actualizar estado */

$sqlActualizar = "
    UPDATE mesa
    SET estado = ?
    WHERE id_mesa = ?
";

$consultaActualizar = $conexion->prepare($sqlActualizar);
$consultaActualizar->bind_param("si", $estado, $idMesa);

if ($consultaActualizar->execute()) {

    header(
        "Location: mesas.php?mensaje=" .
        urlencode("El estado de la mesa se actualizó correctamente.")
    );
    exit();
}

header(
    "Location: mesas.php?error=" .
    urlencode("No fue posible actualizar el estado de la mesa.")
);
exit();