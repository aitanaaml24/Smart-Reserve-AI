<?php

include("includes/proteger.php");
include("includes/conexion.php");

/* Obtener todas las mesas */
$sqlMesas = "
    SELECT
        id_mesa,
        numero_mesa,
        capacidad,
        ubicacion,
        estado
    FROM mesa
    ORDER BY numero_mesa ASC
";

$mesas = $conexion->query($sqlMesas);

/* Contar mesas por estado */
$resumen = $conexion->query("
    SELECT
        SUM(estado = 'Disponible') AS disponibles,
        SUM(estado = 'Reservada') AS reservadas,
        SUM(estado = 'Ocupada') AS ocupadas,
        COUNT(*) AS total
    FROM mesa
")->fetch_assoc();

$mensaje = $_GET["mensaje"] ?? "";
$error = $_GET["error"] ?? "";

include("includes/header.php");
?>

<div class="encabezado-pagina">

    <div>
        <h1>Gestión de mesas</h1>

        <p>
            Consulta y modifica la capacidad, ubicación y estado actual
            de las mesas.
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

<div class="resumen-mesas">

    <div class="resumen-mesa disponible-resumen">
        <span></span>

        <div>
            <h3>Disponibles</h3>
            <strong><?= (int) $resumen["disponibles"] ?></strong>
        </div>
    </div>

    <div class="resumen-mesa reservada-resumen">
        <span></span>

        <div>
            <h3>Reservadas</h3>
            <strong><?= (int) $resumen["reservadas"] ?></strong>
        </div>
    </div>

    <div class="resumen-mesa ocupada-resumen">
        <span></span>

        <div>
            <h3>Ocupadas</h3>
            <strong><?= (int) $resumen["ocupadas"] ?></strong>
        </div>
    </div>

    <div class="resumen-mesa total-resumen">
        <span></span>

        <div>
            <h3>Total</h3>
            <strong><?= (int) $resumen["total"] ?></strong>
        </div>
    </div>

</div>

<div class="grid-mesas">

    <?php if ($mesas && $mesas->num_rows > 0) { ?>

        <?php while ($mesa = $mesas->fetch_assoc()) { ?>

            <?php
                $estadoClase = strtolower($mesa["estado"]);
            ?>

            <div class="tarjeta-mesa <?= $estadoClase ?>-borde">

                <div class="mesa-numero">
                    Mesa <?= $mesa["numero_mesa"] ?>
                </div>

                <div class="mesa-icono">
                    
                </div>

                <div class="mesa-informacion">

                    <p>
                        <strong>Capacidad:</strong>
                        <?= $mesa["capacidad"] ?> personas
                    </p>

                    <p>
                        <strong>Ubicación:</strong>
                        <?= htmlspecialchars($mesa["ubicacion"]) ?>
                    </p>

                </div>

                <span class="estado <?= $estadoClase ?>">
                    <?= htmlspecialchars($mesa["estado"]) ?>
                </span>

                <form
                    action="actualizar_estado_mesa.php"
                    method="POST"
                    class="form-estado-mesa"
                >

                    <input
                        type="hidden"
                        name="id_mesa"
                        value="<?= $mesa["id_mesa"] ?>"
                    >

                    <label for="estado_<?= $mesa["id_mesa"] ?>">
                        Cambiar estado
                    </label>

                    <select
                        id="estado_<?= $mesa["id_mesa"] ?>"
                        name="estado"
                        required
                    >

                        <option
                            value="Disponible"
                            <?= $mesa["estado"] === "Disponible" ? "selected" : "" ?>
                        >
                            Disponible
                        </option>

                        <option
                            value="Reservada"
                            <?= $mesa["estado"] === "Reservada" ? "selected" : "" ?>
                        >
                            Reservada
                        </option>

                        <option
                            value="Ocupada"
                            <?= $mesa["estado"] === "Ocupada" ? "selected" : "" ?>
                        >
                            Ocupada
                        </option>

                    </select>

                    <button
                        type="submit"
                        class="boton boton-principal boton-mesa"
                    >
                        Actualizar
                    </button>

                </form>

            </div>

        <?php } ?>

    <?php } else { ?>

        <p>No hay mesas registradas.</p>

    <?php } ?>

</div>

<?php include("includes/footer.php"); ?>
