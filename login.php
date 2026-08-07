<?php

session_start();

if (isset($_SESSION['id_usuario'])) {
    header("Location: dashboard.php");
    exit();
}

include("includes/conexion.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $correo = trim($_POST["correo"] ?? "");
    $contrasena = $_POST["contrasena"] ?? "";

    $sql = "
        SELECT
            id_usuario,
            nombre,
            correo,
            rol
        FROM usuario
        WHERE correo = ?
          AND `contraseña` = ?
        LIMIT 1
    ";

    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("ss", $correo, $contrasena);
    $consulta->execute();

    $resultado = $consulta->get_result();

    if ($resultado->num_rows === 1) {

        $usuario = $resultado->fetch_assoc();

        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nombre_usuario"] = $usuario["nombre"];
        $_SESSION["correo_usuario"] = $usuario["correo"];
        $_SESSION["rol_usuario"] = $usuario["rol"];

        header("Location: dashboard.php");
        exit();

    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión</title>

    <link rel="stylesheet" href="css/estilos.css">
</head>

<body class="login-body">

<div class="login-card">

    <div class="login-icono">🍽️</div>

    <h1>Smart Reserve AI</h1>

    <p class="login-subtitulo">
        Sistema de gestión de restaurante
    </p>

    <?php if ($error !== "") { ?>

        <div class="alerta error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php } ?>

    <form method="POST">

        <div class="campo">
            <label for="correo">Correo electrónico</label>

            <input
                type="email"
                id="correo"
                name="correo"
                required
                autocomplete="email"
                placeholder="usuario@restaurante.com"
            >
        </div>

        <div class="campo">
            <label for="contrasena">Contraseña</label>

            <input
                type="password"
                id="contrasena"
                name="contrasena"
                required
                autocomplete="current-password"
                placeholder="Ingresa tu contraseña"
            >
        </div>

        <button type="submit" class="boton boton-principal boton-completo">
            Iniciar sesión
        </button>

    </form>

    <div class="datos-prueba">
        <strong>Usuario de prueba</strong><br>
        Correo: laura.gomez@restaurante.com<br>
        Contraseña: admin123
    </div>

</div>

</body>
</html>