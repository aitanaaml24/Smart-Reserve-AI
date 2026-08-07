<?php

include("includes/proteger.php");
include("includes/conexion.php");

$clientes = $conexion->query("
    SELECT
        id_cliente,
        nombre
    FROM cliente
    ORDER BY nombre ASC
");

$mesas = $conexion->query("
    SELECT
        id_mesa,
        numero_mesa,
        capacidad,
        ubicacion,
        estado
    FROM mesa
    WHERE estado <> 'Ocupada'
    ORDER BY capacidad ASC, numero_mesa ASC
");

$error = trim($_GET["error"] ?? "");

include("includes/header.php");
?>

<div class="encabezado-pagina">

    <div>
        <h1>Nueva reservación</h1>

        <p>
            Registra una reservación y valida automáticamente
            la capacidad y disponibilidad de la mesa.
        </p>
    </div>

    <a
        href="reservaciones.php"
        class="boton boton-secundario"
    >
        Volver
    </a>

</div>

<?php if ($error !== "") { ?>

    <div class="alerta error">
        <?= htmlspecialchars($error) ?>
    </div>

    <script>
        window.addEventListener("DOMContentLoaded", function () {
            alert(<?= json_encode($error) ?>);
        });
    </script>

<?php } ?>

<div class="formulario-card">

    <form
        action="guardar_reservacion.php"
        method="POST"
    >

        <div class="form-grid">

            <div class="campo">

                <label for="id_cliente">
                    Cliente
                </label>

                <select
                    id="id_cliente"
                    name="id_cliente"
                    required
                >

                    <option value="">
                        Selecciona un cliente
                    </option>

                    <?php if ($clientes) { ?>

                        <?php while (
                            $cliente = $clientes->fetch_assoc()
                        ) { ?>

                            <option
                                value="<?= $cliente["id_cliente"] ?>"
                            >
                                <?= htmlspecialchars(
                                    $cliente["nombre"]
                                ) ?>
                            </option>

                        <?php } ?>

                    <?php } ?>

                </select>

            </div>

            <div class="campo">

                <label for="numero_personas">
                    Número de personas
                </label>

                <input
                    type="number"
                    id="numero_personas"
                    name="numero_personas"
                    min="1"
                    max="10"
                    required
                >

            </div>

            <div class="campo">

                <label for="fecha">
                    Fecha
                </label>

                <input
                    type="date"
                    id="fecha"
                    name="fecha"
                    min="<?= date("Y-m-d") ?>"
                    required
                >

            </div>

            <div class="campo">

                <label for="hora">
                    Hora
                </label>

                <input
                    type="time"
                    id="hora"
                    name="hora"
                    required
                >

            </div>

            <div class="campo campo-completo">

                <label for="id_mesa">
                    Mesa
                </label>

                <select
                    id="id_mesa"
                    name="id_mesa"
                    required
                >

                    <option value="">
                        Selecciona una mesa
                    </option>

                    <?php if ($mesas) { ?>

                        <?php while (
                            $mesa = $mesas->fetch_assoc()
                        ) { ?>

                            <option
                                value="<?= $mesa["id_mesa"] ?>"
                                data-capacidad="<?= $mesa["capacidad"] ?>"
                                data-estado="<?= htmlspecialchars(
                                    $mesa["estado"]
                                ) ?>"
                            >
                                Mesa <?= $mesa["numero_mesa"] ?>
                                —
                                <?= $mesa["capacidad"] ?> personas
                                —
                                <?= htmlspecialchars(
                                    $mesa["ubicacion"]
                                ) ?>
                                —
                                <?= htmlspecialchars(
                                    $mesa["estado"]
                                ) ?>
                            </option>

                        <?php } ?>

                    <?php } ?>

                </select>

                <small id="mensaje-mesa">
                    El sistema verificará automáticamente
                    la capacidad y disponibilidad.
                </small>

            </div>

            <div class="campo campo-completo">

                <label for="observaciones">
                    Observaciones
                </label>

                <textarea
                    id="observaciones"
                    name="observaciones"
                    rows="4"
                    maxlength="255"
                    placeholder="Cumpleaños, alergias, ubicación preferida, etc."
                ></textarea>

            </div>

        </div>

        <div class="form-acciones">

            <button
                type="submit"
                class="boton boton-principal"
            >
                Guardar reservación
            </button>

            <a
                href="reservaciones.php"
                class="boton boton-secundario"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

<script>
const campoPersonas =
    document.getElementById("numero_personas");

const campoMesa =
    document.getElementById("id_mesa");

const mensajeMesa =
    document.getElementById("mensaje-mesa");

function revisarCapacidad() {

    const opcion =
        campoMesa.options[campoMesa.selectedIndex];

    const personas =
        Number(campoPersonas.value);

    const capacidad =
        Number(opcion?.dataset?.capacidad || 0);

    if (!campoMesa.value) {
        mensajeMesa.textContent =
            "Selecciona una mesa para consultar su capacidad.";

        mensajeMesa.style.color = "#64748b";
        return;
    }

    if (personas > 0 && personas > capacidad) {

        mensajeMesa.textContent =
            "Esta mesa no tiene capacidad suficiente.";

        mensajeMesa.style.color = "#dc2626";

    } else {

        mensajeMesa.textContent =
            "Capacidad de la mesa: " +
            capacidad +
            " personas.";

        mensajeMesa.style.color = "#16a34a";
    }
}

campoPersonas.addEventListener(
    "input",
    revisarCapacidad
);

campoMesa.addEventListener(
    "change",
    revisarCapacidad
);
</script>

<?php include("includes/footer.php"); ?>