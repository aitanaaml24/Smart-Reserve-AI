<?php

include("includes/proteger.php");
include("includes/conexion.php");

$sql = "
    SELECT
        o.id_orden,
        o.id_reservacion,
        o.estado,
        o.total,
        c.nombre AS cliente,
        m.numero_mesa,
        u.nombre AS empleado,
        o.fecha,
        o.hora
    FROM orden o
    INNER JOIN cliente c
        ON o.id_cliente = c.id_cliente
    INNER JOIN mesa m
        ON o.id_mesa = m.id_mesa
    INNER JOIN usuario u
        ON o.id_usuario = u.id_usuario
    ORDER BY o.id_orden DESC
";

$ordenes = $conexion->query($sql);

$mensaje = trim($_GET["mensaje"] ?? "");
$error = trim($_GET["error"] ?? "");

include("includes/header.php");
?>

<div class="encabezado-pagina">

    <div>
        <h1>Órdenes</h1>

        <p>
            Administra las órdenes generadas a partir de reservaciones confirmadas.
        </p>
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

<div class="tabla-contenedor">

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Reservación</th>
                <th>Cliente</th>
                <th>Mesa</th>
                <th>Empleado</th>
                <th>Fecha y hora</th>
                <th>Estado</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

        <?php if ($ordenes && $ordenes->num_rows > 0) { ?>

            <?php while ($orden = $ordenes->fetch_assoc()) { ?>

                <?php
                    $claseEstado = strtolower($orden["estado"]);
                ?>

                <tr>

                    <td>
                        <?= (int) $orden["id_orden"] ?>
                    </td>

                    <td>
                        <?php if ($orden["id_reservacion"] !== null) { ?>
                            #<?= (int) $orden["id_reservacion"] ?>
                        <?php } else { ?>
                            Sin reservación
                        <?php } ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($orden["cliente"]) ?>
                    </td>

                    <td>
                        Mesa <?= (int) $orden["numero_mesa"] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($orden["empleado"]) ?>
                    </td>

                    <td>
                        <?= date(
                            "d/m/Y",
                            strtotime($orden["fecha"])
                        ) ?>

                        <br>

                        <?= date(
                            "H:i",
                            strtotime($orden["hora"])
                        ) ?>
                    </td>

                    <td>
                        <span class="estado-orden <?= $claseEstado ?>">
                            <?= htmlspecialchars($orden["estado"]) ?>
                        </span>
                    </td>

                    <td>
                        <strong>
                            $<?= number_format(
                                (float) $orden["total"],
                                2
                            ) ?>
                        </strong>
                    </td>

                    <td class="acciones">

                        <a
                            href="detalle_orden.php?id=<?= (int) $orden["id_orden"] ?>"
                            class="boton-accion ver-detalle"
                        >
                            Ver detalle
                        </a>

                        <?php if ($orden["estado"] === "Abierta") { ?>

                            <a
                                href="agregar_platillos.php?id=<?= (int) $orden["id_orden"] ?>"
                                class="boton-accion agregar-producto"
                            >
                                Agregar platillos
                            </a>

                        <?php } ?>

                    </td>

                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="9" class="sin-registros">
                    No hay órdenes registradas.
                </td>
            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

<?php include("includes/footer.php"); ?>
