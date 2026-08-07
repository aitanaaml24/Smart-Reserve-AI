<?php

include("includes/proteger.php");
include("includes/conexion.php");

/* =========================================
   INDICADORES GENERALES
========================================= */

$totalClientes = $conexion
    ->query("SELECT COUNT(*) AS total FROM cliente")
    ->fetch_assoc()["total"];

$totalOrdenes = $conexion
    ->query("SELECT COUNT(*) AS total FROM orden")
    ->fetch_assoc()["total"];

$totalReservaciones = $conexion
    ->query("SELECT COUNT(*) AS total FROM reservacion")
    ->fetch_assoc()["total"];

$totalMesas = $conexion
    ->query("SELECT COUNT(*) AS total FROM mesa")
    ->fetch_assoc()["total"];

$totalProductos = $conexion
    ->query("SELECT COUNT(*) AS total FROM menu_items")
    ->fetch_assoc()["total"];

/* Ingresos estimados */

$resultadoIngresos = $conexion->query("
    SELECT COALESCE(SUM(mi.price), 0) AS total
    FROM order_details od
    INNER JOIN menu_items mi
        ON od.item_id = mi.menu_item_id
");

$ingresosEstimados =
    $resultadoIngresos->fetch_assoc()["total"];

/* =========================================
   RESERVACIONES POR ESTADO
========================================= */

$reservacionesPorEstado = $conexion->query("
    SELECT
        estado,
        COUNT(*) AS total
    FROM reservacion
    GROUP BY estado
    ORDER BY total DESC
");

/* =========================================
   MESAS POR ESTADO
========================================= */

$mesasPorEstado = $conexion->query("
    SELECT
        estado,
        COUNT(*) AS total
    FROM mesa
    GROUP BY estado
    ORDER BY total DESC
");

/* =========================================
   PLATILLOS MÁS VENDIDOS
========================================= */

$productosMasVendidos = $conexion->query("
    SELECT
        mi.item_name,
        mi.category,
        mi.price,
        COUNT(od.order_details_id) AS cantidad_vendida,
        SUM(mi.price) AS ingreso_generado
    FROM order_details od
    INNER JOIN menu_items mi
        ON od.item_id = mi.menu_item_id
    GROUP BY
        mi.menu_item_id,
        mi.item_name,
        mi.category,
        mi.price
    ORDER BY cantidad_vendida DESC, ingreso_generado DESC
    LIMIT 10
");

/* =========================================
   ÓRDENES POR EMPLEADO
========================================= */

$ordenesPorEmpleado = $conexion->query("
    SELECT
        u.nombre,
        u.rol,
        COUNT(o.id_orden) AS total_ordenes
    FROM usuario u
    LEFT JOIN orden o
        ON u.id_usuario = o.id_usuario
    GROUP BY
        u.id_usuario,
        u.nombre,
        u.rol
    ORDER BY total_ordenes DESC, u.nombre ASC
");

/* =========================================
   RESERVACIONES RECIENTES
========================================= */

$reservacionesRecientes = $conexion->query("
    SELECT
        r.id_reservacion,
        c.nombre AS cliente,
        m.numero_mesa,
        r.fecha,
        r.hora,
        r.numero_personas,
        r.estado
    FROM reservacion r
    INNER JOIN cliente c
        ON r.id_cliente = c.id_cliente
    INNER JOIN mesa m
        ON r.id_mesa = m.id_mesa
    ORDER BY r.fecha DESC, r.hora DESC
    LIMIT 10
");

include("includes/header.php");

?>

<div class="encabezado-pagina encabezado-reporte">

    <div>
        <h1>Reportes administrativos</h1>

        <p>
            Consulta indicadores generales, ventas, reservaciones
            y desempeño operativo del restaurante.
        </p>
    </div>

    <button
        type="button"
        class="boton boton-principal boton-imprimir"
        onclick="window.print()"
    >
        <i class="bi bi-printer"></i>
        Imprimir reporte
    </button>

</div>

<div class="datos-reporte">

    <p>
        <i class="bi bi-calendar3"></i>

        <strong>Fecha de generación:</strong>
        <?= date("d/m/Y") ?>
    </p>

    <p>
        <i class="bi bi-clock"></i>

        <strong>Hora:</strong>
        <?= date("H:i:s") ?>
    </p>

    <p>
        <i class="bi bi-person"></i>

        <strong>Generado por:</strong>

        <?= htmlspecialchars(
            $_SESSION["nombre_usuario"] ?? "Usuario del sistema"
        ) ?>
    </p>

</div>

<!-- RESUMEN GENERAL -->

<section class="seccion-reporte">

    <h2>Resumen general</h2>

    <div class="cards reporte-cards">

        <div class="card">

            <span class="card-icono">
                <i class="bi bi-people"></i>
            </span>

            <h3>Clientes</h3>

            <h2>
                <?= (int) $totalClientes ?>
            </h2>

        </div>

        <div class="card">

            <span class="card-icono">
                <i class="bi bi-receipt"></i>
            </span>

            <h3>Órdenes</h3>

            <h2>
                <?= (int) $totalOrdenes ?>
            </h2>

        </div>

        <div class="card">

            <span class="card-icono">
                <i class="bi bi-calendar-check"></i>
            </span>

            <h3>Reservaciones</h3>

            <h2>
                <?= (int) $totalReservaciones ?>
            </h2>

        </div>

        <div class="card">

            <span class="card-icono">
                <i class="bi bi-grid-3x3-gap"></i>
            </span>

            <h3>Mesas</h3>

            <h2>
                <?= (int) $totalMesas ?>
            </h2>

        </div>

        <div class="card">

            <span class="card-icono">
                <i class="bi bi-journal-text"></i>
            </span>

            <h3>Platillos</h3>

            <h2>
                <?= (int) $totalProductos ?>
            </h2>

        </div>

        <div class="card">

            <span class="card-icono icono-ingresos">
                <i class="bi bi-cash-stack"></i>
            </span>

            <h3>Ingresos estimados</h3>

            <h2>
                $<?= number_format(
                    (float) $ingresosEstimados,
                    2
                ) ?>
            </h2>

        </div>

    </div>

</section>

<!-- ESTADO DE LA OPERACIÓN -->

<section class="seccion-reporte">

    <h2>Estado de la operación</h2>

    <div class="dos-columnas-reporte">

        <!-- RESERVACIONES POR ESTADO -->

        <div class="reporte-panel">

            <h3>
                <i class="bi bi-calendar-event"></i>
                Reservaciones por estado
            </h3>

            <table>

                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (
                    $reservacionesPorEstado &&
                    $reservacionesPorEstado->num_rows > 0
                ) { ?>

                    <?php while (
                        $fila = $reservacionesPorEstado->fetch_assoc()
                    ) { ?>

                        <?php
                            $claseEstado =
                                strtolower($fila["estado"]);
                        ?>

                        <tr>

                            <td>

                                <span
                                    class="estado <?= $claseEstado ?>"
                                >
                                    <?= htmlspecialchars(
                                        $fila["estado"]
                                    ) ?>
                                </span>

                            </td>

                            <td>
                                <?= (int) $fila["total"] ?>
                            </td>

                        </tr>

                    <?php } ?>

                <?php } else { ?>

                    <tr>

                        <td colspan="2" class="sin-registros">
                            No existen reservaciones registradas.
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

        <!-- MESAS POR ESTADO -->

        <div class="reporte-panel">

            <h3>
                <i class="bi bi-grid"></i>
                Mesas por estado
            </h3>

            <table>

                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (
                    $mesasPorEstado &&
                    $mesasPorEstado->num_rows > 0
                ) { ?>

                    <?php while (
                        $fila = $mesasPorEstado->fetch_assoc()
                    ) { ?>

                        <?php
                            $claseEstado =
                                strtolower($fila["estado"]);
                        ?>

                        <tr>

                            <td>

                                <span
                                    class="estado <?= $claseEstado ?>"
                                >
                                    <?= htmlspecialchars(
                                        $fila["estado"]
                                    ) ?>
                                </span>

                            </td>

                            <td>
                                <?= (int) $fila["total"] ?>
                            </td>

                        </tr>

                    <?php } ?>

                <?php } else { ?>

                    <tr>

                        <td colspan="2" class="sin-registros">
                            No existen mesas registradas.
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</section>

<!-- PLATILLOS MÁS VENDIDOS -->

<section class="seccion-reporte">

    <h2>
        <i class="bi bi-trophy"></i>
        Platillos más vendidos
    </h2>

    <div class="tabla-contenedor">

        <table>

            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Platillo</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Unidades vendidas</th>
                    <th>Ingreso generado</th>
                </tr>
            </thead>

            <tbody>

            <?php if (
                $productosMasVendidos &&
                $productosMasVendidos->num_rows > 0
            ) { ?>

                <?php $posicion = 1; ?>

                <?php while (
                    $producto =
                        $productosMasVendidos->fetch_assoc()
                ) { ?>

                    <tr>

                        <td>
                            <?= $posicion ?>
                        </td>

                        <td>

                            <strong>
                                <?= htmlspecialchars(
                                    $producto["item_name"]
                                ) ?>
                            </strong>

                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $producto["category"]
                            ) ?>
                        </td>

                        <td>
                            $<?= number_format(
                                (float) $producto["price"],
                                2
                            ) ?>
                        </td>

                        <td>
                            <?= (int) $producto["cantidad_vendida"] ?>
                        </td>

                        <td>
                            $<?= number_format(
                                (float) $producto["ingreso_generado"],
                                2
                            ) ?>
                        </td>

                    </tr>

                    <?php $posicion++; ?>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="6" class="sin-registros">
                        No existen ventas registradas.
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</section>

<!-- ÓRDENES POR EMPLEADO -->

<section class="seccion-reporte">

    <h2>
        <i class="bi bi-person-workspace"></i>
        Órdenes atendidas por empleado
    </h2>

    <div class="tabla-contenedor">

        <table>

            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Rol</th>
                    <th>Órdenes atendidas</th>
                </tr>
            </thead>

            <tbody>

            <?php if (
                $ordenesPorEmpleado &&
                $ordenesPorEmpleado->num_rows > 0
            ) { ?>

                <?php while (
                    $empleado =
                        $ordenesPorEmpleado->fetch_assoc()
                ) { ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                $empleado["nombre"]
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $empleado["rol"]
                            ) ?>
                        </td>

                        <td>
                            <?= (int) $empleado["total_ordenes"] ?>
                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="3" class="sin-registros">
                        No existen usuarios registrados.
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</section>

<!-- RESERVACIONES RECIENTES -->

<section class="seccion-reporte">

    <h2>
        <i class="bi bi-clock-history"></i>
        Reservaciones recientes
    </h2>

    <div class="tabla-contenedor">

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Mesa</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Personas</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>

            <?php if (
                $reservacionesRecientes &&
                $reservacionesRecientes->num_rows > 0
            ) { ?>

                <?php while (
                    $reservacion =
                        $reservacionesRecientes->fetch_assoc()
                ) { ?>

                    <?php
                        $claseEstado =
                            strtolower($reservacion["estado"]);
                    ?>

                    <tr>

                        <td>
                            <?= (int) $reservacion["id_reservacion"] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $reservacion["cliente"]
                            ) ?>
                        </td>

                        <td>
                            Mesa
                            <?= (int) $reservacion["numero_mesa"] ?>
                        </td>

                        <td>
                            <?= date(
                                "d/m/Y",
                                strtotime($reservacion["fecha"])
                            ) ?>
                        </td>

                        <td>
                            <?= date(
                                "H:i",
                                strtotime($reservacion["hora"])
                            ) ?>
                        </td>

                        <td>
                            <?= (int) $reservacion["numero_personas"] ?>
                        </td>

                        <td>

                            <span
                                class="estado <?= $claseEstado ?>"
                            >
                                <?= htmlspecialchars(
                                    $reservacion["estado"]
                                ) ?>
                            </span>

                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>

                    <td colspan="7" class="sin-registros">
                        No existen reservaciones registradas.
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</section>

<?php include("includes/footer.php"); ?>

