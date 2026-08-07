<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$paginaActual = basename($_SERVER["PHP_SELF"]);

function enlaceActivo(
    string $archivo,
    string $paginaActual
): string {
    return $archivo === $paginaActual
        ? "activo"
        : "";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Smart Reserve AI</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="css/estilos.css"
    >

</head>

<body>

<header class="barra-superior">

    <div class="barra-contenido">

        <a
            href="dashboard.php"
            class="logo-sistema"
        >

            <span class="logo-icono">
                <i class="bi bi-calendar2-check"></i>
            </span>

            <span class="logo-texto">

                <strong>Smart Reserve</strong>

                <small>Gestión inteligente</small>

            </span>

        </a>

        <button
            type="button"
            class="boton-menu-movil"
            id="boton-menu-movil"
            aria-label="Abrir menú de navegación"
            aria-expanded="false"
        >
            <i class="bi bi-list"></i>
        </button>

        <nav
            class="navegacion-principal"
            id="navegacion-principal"
        >

            <ul>

                <li>

                    <a
                        href="index.php"
                        class="<?= enlaceActivo(
                            "index.php",
                            $paginaActual
                        ) ?>"
                    >

                        <i class="bi bi-house-door"></i>

                        <span>Inicio</span>

                    </a>

                </li>

                <li>

                    <a
                        href="dashboard.php"
                        class="<?= enlaceActivo(
                            "dashboard.php",
                            $paginaActual
                        ) ?>"
                    >

                        <i class="bi bi-grid-1x2"></i>

                        <span>Dashboard</span>

                    </a>

                </li>

                <li>

                    <a
                        href="clientes.php"
                        class="<?= enlaceActivo(
                            "clientes.php",
                            $paginaActual
                        ) ?>"
                    >

                        <i class="bi bi-people"></i>

                        <span>Clientes</span>

                    </a>

                </li>

                <li>

                    <a
                        href="menu.php"
                        class="<?= enlaceActivo(
                            "menu.php",
                            $paginaActual
                        ) ?>"
                    >

                        <i class="bi bi-journal-text"></i>

                        <span>Menú</span>

                    </a>

                </li>

                <li>

                    <a
                        href="mesas.php"
                        class="<?= enlaceActivo(
                            "mesas.php",
                            $paginaActual
                        ) ?>"
                    >

                        <i class="bi bi-layout-text-window"></i>

                        <span>Mesas</span>

                    </a>

                </li>

                <li>

                    <a
                        href="reservaciones.php"
                        class="<?= enlaceActivo(
                            "reservaciones.php",
                            $paginaActual
                        ) ?>"
                    >

                        <i class="bi bi-calendar-event"></i>

                        <span>Reservaciones</span>

                    </a>

                </li>

                <li>

                    <a
                        href="ordenes.php"
                        class="<?= enlaceActivo(
                            "ordenes.php",
                            $paginaActual
                        ) ?>"
                    >

                        <i class="bi bi-receipt"></i>

                        <span>Órdenes</span>

                    </a>

                </li>

                <li>

                    <a
                        href="reportes.php"
                        class="<?= enlaceActivo(
                            "reportes.php",
                            $paginaActual
                        ) ?>"
                    >

                        <i class="bi bi-bar-chart-line"></i>

                        <span>Reportes</span>

                    </a>

                </li>

            </ul>

        </nav>

        <div class="perfil-usuario">

            <div class="avatar-usuario">

                <i class="bi bi-person"></i>

            </div>

            <div class="datos-usuario">

                <strong>
                    <?= htmlspecialchars(
                        $_SESSION["nombre_usuario"]
                        ?? "Usuario"
                    ) ?>
                </strong>

                <small>
                    <?= htmlspecialchars(
                        $_SESSION["rol_usuario"]
                        ?? "Sin rol"
                    ) ?>
                </small>

            </div>

            <a
                href="logout.php"
                class="boton-salir"
                title="Cerrar sesión"
            >

                <i class="bi bi-box-arrow-right"></i>

                <span>Salir</span>

            </a>

        </div>

    </div>

</header>

<main class="contenido-principal">

    <div class="container">
