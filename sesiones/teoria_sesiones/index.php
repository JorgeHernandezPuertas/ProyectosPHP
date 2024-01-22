<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría de Sesiones PHP</title>
</head>

<body>
    <h1>Teoría de Sesiones PHP</h1>
    <p><a href="recibido.php">Ir a Recibido</a></p>
    <?php
    if (isset($_POST["btnBorrarSession"])) {
        // session_destroy(); // Destruye la sesión
        session_unset(); // Borra todos los datos de la sesión
    }
    if (!isset($_SESSION["nombre"]) && !isset($_POST["btnBorrarSession"])) {
        $_SESSION["nombre"] = "Miguel Santos";
        $_SESSION["clave"] = md5("123456");
    }
    if (isset($_SESSION["nombre"])) {
    ?>
        <p>Nombre: <?php if (isset($_SESSION["nombre"])) print $_SESSION["nombre"] ?></p>
        <p>Clave: <?php if (isset($_SESSION["clave"])) print $_SESSION["clave"] ?></p>
    <?php
    } else {
        print "<p>Se han borrado los valores de sesión</p>";
    }
    ?>

    <form action="index.php" method="post">
        <button name="btnBorrarSession">Borrar datos sesión</button>
    </form>
</body>

</html>