<?php

include("includes/proteger.php");
include("includes/conexion.php");

/* Obtener todas las reservaciones */

$sql = "
    SELECT
        r.id_reservacion,
        r.fecha,
        r.hora,
        r.numero_personas,
        r.estado,
        r.observaciones,
        c.nombre AS cliente,
        c.telefono,
        m.numero_mesa,
        m.capacidad,
        m.ubicacion
    FROM reservacion r
    INNER JOIN cliente c
        ON r.id_cliente = c.id_cliente
    INNER JOIN mesa m
        ON r.id_mesa = m.id_mesa
    ORDER BY r.fecha DESC, r.hora DESC
";

$resultado = $conexion->query($sql);

/* Mensajes enviados mediante la URL */

$mensaje = trim($_GET["mensaje"] ?? "");
$error = trim($_GET["error"] ?? "");

include("includes/header.php");

?>

<div class="encabezado-pagina">

    <div>
        <h1>Reservaciones</h1>

        <p>
            Consulta y administra las reservaciones del restaurante.
        </p>
    </div>

    <a
        href="nueva_reservacion.php"
        class="boton boton-principal"
    >
        + Nueva reservación
    </a>

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

<div class="tabla-contenedor">

    <table>

        <thead>

            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Mesa</th>
                <th>Fecha y hora</th>
                <th>Personas</th>
                <th>Estado</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>

        </thead>

        <tbody>

        <?php if ($resultado && $resultado->num_rows > 0) { ?>

            <?php while ($fila = $resultado->fetch_assoc()) { ?>

                <?php
                    $estadoClase = strtolower($fila["estado"]);
                ?>

                <tr>

                    <td>
                        <?= (int) $fila["id_reservacion"] ?>
                    </td>

                    <td>

                        <strong>
                            <?= htmlspecialchars($fila["cliente"]) ?>
                        </strong>

                        <br>

                        <small>
                            <?= htmlspecialchars($fila["telefono"]) ?>
                        </small>

                    </td>

                    <td>

                        Mesa <?= (int) $fila["numero_mesa"] ?>

                        <br>

                        <small>
                            <?= htmlspecialchars($fila["ubicacion"]) ?>
                            · capacidad
                            <?= (int) $fila["capacidad"] ?>
                        </small>

                    </td>

                    <td>

                        <?= date(
                            "d/m/Y",
                            strtotime($fila["fecha"])
                        ) ?>

                        <br>

                        <?= date(
                            "H:i",
                            strtotime($fila["hora"])
                        ) ?>

                    </td>

                    <td>
                        <?= (int) $fila["numero_personas"] ?>
                    </td>

                    <td>

                        <span class="estado <?= $estadoClase ?>">

                            <?= htmlspecialchars($fila["estado"]) ?>

                        </span>

                    </td>

                    <td>

                        <?php if (
                            trim((string) $fila["observaciones"]) !== ""
                        ) { ?>

                            <?= htmlspecialchars(
                                $fila["observaciones"]
                            ) ?>

                        <?php } else { ?>

                            Sin observaciones

                        <?php } ?>

                    </td>

                    <td class="acciones">

                        <?php if (
                            $fila["estado"] === "Pendiente"
                        ) { ?>

                            <a
                                href="cambiar_estado.php?id=<?= (int) $fila["id_reservacion"] ?>&estado=Confirmada"
                                class="boton-accion confirmar"
                                onclick="return confirm(
                                    '¿Confirmar esta reservación? La mesa cambiará a ocupada.'
                                );"
                            >
                                Confirmar
                            </a>

                            <a
                                href="cambiar_estado.php?id=<?= (int) $fila["id_reservacion"] ?>&estado=Cancelada"
                                class="boton-accion cancelar"
                                onclick="return confirm(
                                    '¿Cancelar esta reservación? La mesa volverá a estar disponible.'
                                );"
                            >
                                Cancelar
                            </a>

                        <?php } ?>

                        <?php if (
                            $fila["estado"] === "Confirmada"
                        ) { ?>

                            <a
                                href="cambiar_estado.php?id=<?= (int) $fila["id_reservacion"] ?>&estado=Cancelada"
                                class="boton-accion cancelar"
                                onclick="return confirm(
                                    '¿Cancelar esta reservación?'
                                );"
                            >
                                Cancelar
                            </a>

                            <a
                                href="cambiar_estado.php?id=<?= (int) $fila["id_reservacion"] ?>&estado=Completada"
                                class="boton-accion completar"
                                onclick="return confirm(
                                    '¿Marcar esta reservación como completada? La mesa volverá a estar disponible.'
                                );"
                            >
                                Completar
                            </a>

                        <?php } ?>

                        <?php if (
                            $fila["estado"] === "Cancelada"
                        ) { ?>

                            <span class="accion-finalizada">
                                Sin acciones
                            </span>

                        <?php } ?>

                        <?php if (
                            $fila["estado"] === "Completada"
                        ) { ?>

                            <span class="accion-finalizada">
                                Finalizada
                            </span>

                        <?php } ?>

                    </td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>

                <td
                    colspan="8"
                    class="sin-registros"
                >
                    No hay reservaciones registradas.
                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

<?php include("includes/footer.php"); ?>