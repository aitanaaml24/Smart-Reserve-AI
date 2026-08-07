<?php

include("includes/proteger.php");
include("includes/conexion.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: nueva_reservacion.php");
    exit();
}

$idCliente = (int) ($_POST["id_cliente"] ?? 0);
$idMesa = (int) ($_POST["id_mesa"] ?? 0);
$fecha = trim($_POST["fecha"] ?? "");
$hora = trim($_POST["hora"] ?? "");
$numeroPersonas = (int) ($_POST["numero_personas"] ?? 0);
$observaciones = trim($_POST["observaciones"] ?? "");

function regresarConError(string $mensaje): void
{
    header(
        "Location: nueva_reservacion.php?error=" .
        urlencode($mensaje)
    );
    exit();
}

/* Validar campos obligatorios */

if (
    $idCliente <= 0 ||
    $idMesa <= 0 ||
    $fecha === "" ||
    $hora === "" ||
    $numeroPersonas <= 0
) {
    regresarConError("Completa todos los campos obligatorios.");
}

/* Validar fecha */

if ($fecha < date("Y-m-d")) {
    regresarConError(
        "La fecha de la reservación no puede ser anterior a la fecha actual."
    );
}

/* Validar que el cliente exista */

$sqlCliente = "
    SELECT id_cliente
    FROM cliente
    WHERE id_cliente = ?
";

$consultaCliente = $conexion->prepare($sqlCliente);

if (!$consultaCliente) {
    regresarConError("No fue posible validar el cliente.");
}

$consultaCliente->bind_param("i", $idCliente);
$consultaCliente->execute();

$resultadoCliente = $consultaCliente->get_result();

if ($resultadoCliente->num_rows !== 1) {
    regresarConError("El cliente seleccionado no existe.");
}

/* Validar mesa y capacidad */

$sqlMesa = "
    SELECT
        id_mesa,
        numero_mesa,
        capacidad,
        estado
    FROM mesa
    WHERE id_mesa = ?
";

$consultaMesa = $conexion->prepare($sqlMesa);

if (!$consultaMesa) {
    regresarConError("No fue posible validar la mesa.");
}

$consultaMesa->bind_param("i", $idMesa);
$consultaMesa->execute();

$resultadoMesa = $consultaMesa->get_result();

if ($resultadoMesa->num_rows !== 1) {
    regresarConError("La mesa seleccionada no existe.");
}

$mesa = $resultadoMesa->fetch_assoc();

if ($numeroPersonas > (int) $mesa["capacidad"]) {
    regresarConError(
        "La mesa " .
        $mesa["numero_mesa"] .
        " solo tiene capacidad para " .
        $mesa["capacidad"] .
        " personas."
    );
}

/* Validar disponibilidad en fecha y hora */

$sqlDisponibilidad = "
    SELECT id_reservacion
    FROM reservacion
    WHERE id_mesa = ?
      AND fecha = ?
      AND hora = ?
      AND estado IN ('Pendiente', 'Confirmada')
    LIMIT 1
";

$consultaDisponibilidad = $conexion->prepare($sqlDisponibilidad);

if (!$consultaDisponibilidad) {
    regresarConError(
        "No fue posible comprobar la disponibilidad de la mesa."
    );
}

$consultaDisponibilidad->bind_param(
    "iss",
    $idMesa,
    $fecha,
    $hora
);

$consultaDisponibilidad->execute();

$resultadoDisponibilidad =
    $consultaDisponibilidad->get_result();

if ($resultadoDisponibilidad->num_rows > 0) {
    regresarConError(
        "La mesa seleccionada ya está reservada para esa fecha y hora."
    );
}

/* Registrar reservación */

try {

    $conexion->begin_transaction();

    $sqlInsertar = "
        INSERT INTO reservacion (
            id_cliente,
            id_mesa,
            fecha,
            hora,
            numero_personas,
            estado,
            observaciones
        )
        VALUES (?, ?, ?, ?, ?, 'Pendiente', ?)
    ";

    $consultaInsertar = $conexion->prepare($sqlInsertar);

    if (!$consultaInsertar) {
        throw new Exception(
            "No fue posible preparar el registro de la reservación."
        );
    }

    $consultaInsertar->bind_param(
        "iissis",
        $idCliente,
        $idMesa,
        $fecha,
        $hora,
        $numeroPersonas,
        $observaciones
    );

    $consultaInsertar->execute();

    /* Cambiar el estado visual de la mesa */

    $sqlActualizarMesa = "
        UPDATE mesa
        SET estado = 'Reservada'
        WHERE id_mesa = ?
    ";

    $consultaActualizarMesa =
        $conexion->prepare($sqlActualizarMesa);

    if (!$consultaActualizarMesa) {
        throw new Exception(
            "No fue posible actualizar el estado de la mesa."
        );
    }

    $consultaActualizarMesa->bind_param("i", $idMesa);
    $consultaActualizarMesa->execute();

    $conexion->commit();

    header(
        "Location: reservaciones.php?mensaje=" .
        urlencode("Reservación registrada correctamente.")
    );
    exit();

} catch (mysqli_sql_exception $error) {

    $conexion->rollback();

    /*
     * Código 1062:
     * intento de duplicar una mesa en la misma fecha y hora.
     */

    if ((int) $error->getCode() === 1062) {
        regresarConError(
            "La mesa seleccionada ya está reservada para esa fecha y hora."
        );
    }

    regresarConError(
        "No fue posible registrar la reservación. Inténtalo nuevamente."
    );

} catch (Throwable $error) {

    $conexion->rollback();

    regresarConError(
        "No fue posible registrar la reservación. Inténtalo nuevamente."
    );
}