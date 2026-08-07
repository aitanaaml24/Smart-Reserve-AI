<?php

include("includes/proteger.php");
include("includes/conexion.php");

$idReservacion = (int) ($_GET["id"] ?? 0);
$estadoNuevo = trim($_GET["estado"] ?? "");

$estadosPermitidos = [
    "Pendiente",
    "Confirmada",
    "Cancelada",
    "Completada"
];

/**
 * Regresa al listado de reservaciones mostrando un mensaje.
 */
function regresarReservaciones(
    string $mensaje,
    bool $esError = false
): void {

    $parametro = $esError ? "error" : "mensaje";

    header(
        "Location: reservaciones.php?" .
        $parametro .
        "=" .
        urlencode($mensaje)
    );

    exit();
}

/* Validar parámetros */

if (
    $idReservacion <= 0 ||
    !in_array($estadoNuevo, $estadosPermitidos, true)
) {
    regresarReservaciones(
        "La solicitud para cambiar el estado no es válida.",
        true
    );
}

try {

    $conexion->begin_transaction();

    /*
     * Obtener los datos completos de la reservación.
     * Estos datos se utilizarán para actualizar la mesa
     * y crear la orden cuando sea confirmada.
     */

    $sqlReservacion = "
        SELECT
            id_reservacion,
            id_cliente,
            id_mesa,
            fecha,
            hora,
            estado
        FROM reservacion
        WHERE id_reservacion = ?
        LIMIT 1
    ";

    $consultaReservacion =
        $conexion->prepare($sqlReservacion);

    if (!$consultaReservacion) {
        throw new Exception(
            "No fue posible preparar la consulta de la reservación."
        );
    }

    $consultaReservacion->bind_param(
        "i",
        $idReservacion
    );

    $consultaReservacion->execute();

    $resultadoReservacion =
        $consultaReservacion->get_result();

    if ($resultadoReservacion->num_rows !== 1) {
        throw new Exception(
            "La reservación seleccionada no existe."
        );
    }

    $reservacion =
        $resultadoReservacion->fetch_assoc();

    $idCliente = (int) $reservacion["id_cliente"];
    $idMesa = (int) $reservacion["id_mesa"];
    $fecha = $reservacion["fecha"];
    $hora = $reservacion["hora"];

    /*
     * Actualizar el estado de la reservación.
     */

    $sqlActualizarReservacion = "
        UPDATE reservacion
        SET estado = ?
        WHERE id_reservacion = ?
    ";

    $consultaActualizarReservacion =
        $conexion->prepare($sqlActualizarReservacion);

    if (!$consultaActualizarReservacion) {
        throw new Exception(
            "No fue posible preparar la actualización."
        );
    }

    $consultaActualizarReservacion->bind_param(
        "si",
        $estadoNuevo,
        $idReservacion
    );

    $consultaActualizarReservacion->execute();

    /*
     * Flujo de estados:
     *
     * Pendiente  -> mesa Reservada
     * Confirmada -> mesa Ocupada y orden Abierta
     * Cancelada  -> orden Cancelada y mesa liberada
     * Completada -> orden Cerrada y mesa liberada
     */

    $estadoMesa = "Disponible";

    switch ($estadoNuevo) {

        case "Pendiente":

            $estadoMesa = "Reservada";

            break;

        case "Confirmada":

            $estadoMesa = "Ocupada";

            /*
             * El empleado responsable será el usuario
             * que tiene la sesión iniciada.
             */

            $idUsuario = (int) (
                $_SESSION["id_usuario"] ?? 0
            );

            if ($idUsuario <= 0) {
                throw new Exception(
                    "No se pudo identificar al usuario responsable."
                );
            }

            /*
             * Crear una orden abierta.
             *
             * Si la reservación ya tenía una orden,
             * se vuelve a dejar abierta sin duplicarla.
             */

            $sqlCrearOrden = "
                INSERT INTO orden (
                    id_cliente,
                    id_mesa,
                    id_usuario,
                    fecha,
                    hora,
                    id_reservacion,
                    estado,
                    total
                )
                VALUES (
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    ?,
                    'Abierta',
                    0.00
                )
                ON DUPLICATE KEY UPDATE
                    id_cliente = VALUES(id_cliente),
                    id_mesa = VALUES(id_mesa),
                    id_usuario = VALUES(id_usuario),
                    fecha = VALUES(fecha),
                    hora = VALUES(hora),
                    estado = 'Abierta'
            ";

            $consultaCrearOrden =
                $conexion->prepare($sqlCrearOrden);

            if (!$consultaCrearOrden) {
                throw new Exception(
                    "No fue posible preparar la creación de la orden."
                );
            }

            $consultaCrearOrden->bind_param(
                "iiissi",
                $idCliente,
                $idMesa,
                $idUsuario,
                $fecha,
                $hora,
                $idReservacion
            );

            $consultaCrearOrden->execute();

            break;

        case "Cancelada":

            /*
             * Cancelar la orden asociada, si existe.
             */

            $sqlCancelarOrden = "
                UPDATE orden
                SET estado = 'Cancelada'
                WHERE id_reservacion = ?
                  AND estado = 'Abierta'
            ";

            $consultaCancelarOrden =
                $conexion->prepare($sqlCancelarOrden);

            if (!$consultaCancelarOrden) {
                throw new Exception(
                    "No fue posible preparar la cancelación de la orden."
                );
            }

            $consultaCancelarOrden->bind_param(
                "i",
                $idReservacion
            );

            $consultaCancelarOrden->execute();

            $estadoMesa = "Disponible";

            break;

        case "Completada":

            /*
             * Cerrar la orden relacionada.
             */

            $sqlCerrarOrden = "
                UPDATE orden
                SET estado = 'Cerrada'
                WHERE id_reservacion = ?
                  AND estado = 'Abierta'
            ";

            $consultaCerrarOrden =
                $conexion->prepare($sqlCerrarOrden);

            if (!$consultaCerrarOrden) {
                throw new Exception(
                    "No fue posible preparar el cierre de la orden."
                );
            }

            $consultaCerrarOrden->bind_param(
                "i",
                $idReservacion
            );

            $consultaCerrarOrden->execute();

            $estadoMesa = "Disponible";

            break;
    }

    /*
     * Antes de liberar la mesa, se verifica si existe
     * otra reservación activa asociada con ella.
     *
     * Si hay una confirmada, la mesa queda ocupada.
     * Si solamente hay una pendiente, queda reservada.
     */

    if ($estadoMesa === "Disponible") {

        $sqlOtraReservacion = "
            SELECT estado
            FROM reservacion
            WHERE id_mesa = ?
              AND id_reservacion <> ?
              AND estado IN (
                  'Pendiente',
                  'Confirmada'
              )
            ORDER BY
                CASE
                    WHEN estado = 'Confirmada' THEN 1
                    WHEN estado = 'Pendiente' THEN 2
                    ELSE 3
                END
            LIMIT 1
        ";

        $consultaOtraReservacion =
            $conexion->prepare($sqlOtraReservacion);

        if (!$consultaOtraReservacion) {
            throw new Exception(
                "No fue posible verificar otras reservaciones."
            );
        }

        $consultaOtraReservacion->bind_param(
            "ii",
            $idMesa,
            $idReservacion
        );

        $consultaOtraReservacion->execute();

        $resultadoOtraReservacion =
            $consultaOtraReservacion->get_result();

        if ($resultadoOtraReservacion->num_rows === 1) {

            $otraReservacion =
                $resultadoOtraReservacion->fetch_assoc();

            if (
                $otraReservacion["estado"] === "Confirmada"
            ) {
                $estadoMesa = "Ocupada";
            } else {
                $estadoMesa = "Reservada";
            }
        }
    }

    /*
     * Actualizar el estado final de la mesa.
     */

    $sqlActualizarMesa = "
        UPDATE mesa
        SET estado = ?
        WHERE id_mesa = ?
    ";

    $consultaActualizarMesa =
        $conexion->prepare($sqlActualizarMesa);

    if (!$consultaActualizarMesa) {
        throw new Exception(
            "No fue posible preparar la actualización de la mesa."
        );
    }

    $consultaActualizarMesa->bind_param(
        "si",
        $estadoMesa,
        $idMesa
    );

    $consultaActualizarMesa->execute();

    $conexion->commit();

    /*
     * Mensaje final dependiendo de la acción.
     */

    if ($estadoNuevo === "Confirmada") {

        regresarReservaciones(
            "La reservación fue confirmada, la mesa cambió a " .
            "Ocupada y se creó una orden abierta."
        );

    } elseif ($estadoNuevo === "Completada") {

        regresarReservaciones(
            "La reservación fue completada, la orden se cerró " .
            "y la mesa quedó " . $estadoMesa . "."
        );

    } elseif ($estadoNuevo === "Cancelada") {

        regresarReservaciones(
            "La reservación fue cancelada, la orden asociada " .
            "se canceló y la mesa quedó " . $estadoMesa . "."
        );

    } else {

        regresarReservaciones(
            "La reservación cambió a " .
            $estadoNuevo .
            " y la mesa quedó " .
            $estadoMesa .
            "."
        );
    }

} catch (Throwable $error) {

    $conexion->rollback();

    regresarReservaciones(
        "No fue posible actualizar la reservación: " .
        $error->getMessage(),
        true
    );
}