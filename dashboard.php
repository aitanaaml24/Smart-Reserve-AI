<?php

include("includes/proteger.php");
include("includes/conexion.php");

$totalClientes = $conexion
    ->query("SELECT COUNT(*) AS total FROM cliente")
    ->fetch_assoc()["total"];

$totalProductos = $conexion
    ->query("SELECT COUNT(*) AS total FROM menu_items")
    ->fetch_assoc()["total"];

$totalOrdenes = $conexion
    ->query("SELECT COUNT(*) AS total FROM orden")
    ->fetch_assoc()["total"];

$totalReservaciones = $conexion
    ->query("SELECT COUNT(*) AS total FROM reservacion")
    ->fetch_assoc()["total"];

$pendientes = $conexion
    ->query("
        SELECT COUNT(*) AS total
        FROM reservacion
        WHERE estado = 'Pendiente'
    ")
    ->fetch_assoc()["total"];

$confirmadas = $conexion
    ->query("
        SELECT COUNT(*) AS total
        FROM reservacion
        WHERE estado = 'Confirmada'
    ")
    ->fetch_assoc()["total"];

$canceladas = $conexion
    ->query("
        SELECT COUNT(*) AS total
        FROM reservacion
        WHERE estado = 'Cancelada'
    ")
    ->fetch_assoc()["total"];

$completadas = $conexion
    ->query("
        SELECT COUNT(*) AS total
        FROM reservacion
        WHERE estado = 'Completada'
    ")
    ->fetch_assoc()["total"];

$totalMesas = $conexion
    ->query("SELECT COUNT(*) AS total FROM mesa")
    ->fetch_assoc()["total"];

$mesasDisponibles = $conexion
    ->query("
        SELECT COUNT(*) AS total
        FROM mesa
        WHERE estado = 'Disponible'
    ")
    ->fetch_assoc()["total"];

$mesasReservadas = $conexion
    ->query("
        SELECT COUNT(*) AS total
        FROM mesa
        WHERE estado = 'Reservada'
    ")
    ->fetch_assoc()["total"];

$mesasOcupadas = $conexion
    ->query("
        SELECT COUNT(*) AS total
        FROM mesa
        WHERE estado = 'Ocupada'
    ")
    ->fetch_assoc()["total"];

$mesasEnUso =
    (int) $mesasReservadas +
    (int) $mesasOcupadas;

$porcentajeOcupacion = $totalMesas > 0
    ? ($mesasEnUso / $totalMesas) * 100
    : 0;

$porcentajeDisponibilidad = $totalMesas > 0
    ? ($mesasDisponibles / $totalMesas) * 100
    : 0;

include("includes/header.php");

?>

<div class="encabezado-pagina">

    <div>
        <h1>Dashboard</h1>

        <p>
            Resumen general y estadísticas de ocupación del restaurante.
        </p>
    </div>

    <div class="fecha-actual">
        <i class="bi bi-calendar3"></i>
        <?= date("d/m/Y") ?>

        <span class="separador-fecha">|</span>

        <i class="bi bi-clock"></i>
        <?= date("H:i") ?>
    </div>

</div>

<!-- TARJETAS GENERALES -->

<div class="cards">

    <div class="card">
        <span class="card-icono">
            <i class="bi bi-people"></i>
        </span>

        <h3>Clientes</h3>
        <h2><?= (int) $totalClientes ?></h2>
    </div>

    <div class="card">
        <span class="card-icono">
            <i class="bi bi-journal-text"></i>
        </span>

        <h3>Platillos</h3>
        <h2><?= (int) $totalProductos ?></h2>
    </div>

    <div class="card">
        <span class="card-icono">
            <i class="bi bi-receipt"></i>
        </span>

        <h3>Órdenes</h3>
        <h2><?= (int) $totalOrdenes ?></h2>
    </div>

    <div class="card">
        <span class="card-icono">
            <i class="bi bi-calendar-check"></i>
        </span>

        <h3>Reservaciones</h3>
        <h2><?= (int) $totalReservaciones ?></h2>
    </div>

</div>

<section class="seccion-dashboard">

    <div class="titulo-seccion-dashboard">
        <div>
            <h2>Estadísticas de ocupación</h2>
            <p>Estado actual de las mesas del restaurante.</p>
        </div>
    </div>

    <div class="cards">

        <div class="card">
            <span class="card-icono">
                <i class="bi bi-pie-chart"></i>
            </span>

            <h3>Ocupación actual</h3>

            <h2>
                <?= number_format(
                    $porcentajeOcupacion,
                    1
                ) ?>%
            </h2>

            <p>
                Mesas reservadas y ocupadas
            </p>
        </div>

        <div class="card">
            <span class="card-icono">
                <i class="bi bi-speedometer2"></i>
            </span>

            <h3>Disponibilidad</h3>

            <h2>
                <?= number_format(
                    $porcentajeDisponibilidad,
                    1
                ) ?>%
            </h2>

            <p>
                Mesas disponibles actualmente
            </p>
        </div>

        <div class="card">
            <span class="card-icono icono-disponible">
                <i class="bi bi-check-circle"></i>
            </span>

            <h3>Mesas disponibles</h3>
            <h2><?= (int) $mesasDisponibles ?></h2>
        </div>

        <div class="card">
            <span class="card-icono icono-reservada">
                <i class="bi bi-clock-history"></i>
            </span>

            <h3>Mesas reservadas</h3>
            <h2><?= (int) $mesasReservadas ?></h2>
        </div>

        <div class="card">
            <span class="card-icono icono-ocupada">
                <i class="bi bi-person-check"></i>
            </span>

            <h3>Mesas ocupadas</h3>
            <h2><?= (int) $mesasOcupadas ?></h2>
        </div>

        <div class="card">
            <span class="card-icono">
                <i class="bi bi-grid-3x3-gap"></i>
            </span>

            <h3>Total de mesas</h3>
            <h2><?= (int) $totalMesas ?></h2>
        </div>

    </div>

</section>

<section class="seccion-dashboard">

    <div class="panel-estadistica">

        <div class="titulo-estadistica">

            <div>
                <h2>Nivel de ocupación</h2>

                <p>
                    Porcentaje de mesas reservadas u ocupadas
                    respecto al total de mesas.
                </p>
            </div>

            <strong>
                <?= number_format(
                    $porcentajeOcupacion,
                    1
                ) ?>%
            </strong>

        </div>

        <div class="barra-ocupacion">

            <div
                class="barra-ocupacion-progreso"
                style="width:
                    <?= min(
                        100,
                        max(0, $porcentajeOcupacion)
                    ) ?>%;
                "
            ></div>

        </div>

        <div class="leyenda-ocupacion">

            <span class="leyenda-disponible">
                <i class="bi bi-circle-fill"></i>

                Disponibles:
                <?= (int) $mesasDisponibles ?>
            </span>

            <span class="leyenda-reservada">
                <i class="bi bi-circle-fill"></i>

                Reservadas:
                <?= (int) $mesasReservadas ?>
            </span>

            <span class="leyenda-ocupada">
                <i class="bi bi-circle-fill"></i>

                Ocupadas:
                <?= (int) $mesasOcupadas ?>
            </span>

        </div>

    </div>

</section>

<section class="seccion-dashboard">

    <div class="titulo-seccion-dashboard">
        <div>
            <h2>Reservaciones por estado</h2>
            <p>Distribución actual de las reservaciones registradas.</p>
        </div>
    </div>

    <div class="cards">

        <div class="card">
            <span class="card-icono icono-pendiente">
                <i class="bi bi-hourglass-split"></i>
            </span>

            <h3>Pendientes</h3>
            <h2><?= (int) $pendientes ?></h2>
        </div>

        <div class="card">
            <span class="card-icono icono-confirmada">
                <i class="bi bi-check2-circle"></i>
            </span>

            <h3>Confirmadas</h3>
            <h2><?= (int) $confirmadas ?></h2>
        </div>

        <div class="card">
            <span class="card-icono icono-cancelada">
                <i class="bi bi-x-circle"></i>
            </span>

            <h3>Canceladas</h3>
            <h2><?= (int) $canceladas ?></h2>
        </div>

        <div class="card">
            <span class="card-icono icono-completada">
                <i class="bi bi-flag"></i>
            </span>

            <h3>Completadas</h3>
            <h2><?= (int) $completadas ?></h2>
        </div>

    </div>

</section>

<?php include("includes/footer.php"); ?>
