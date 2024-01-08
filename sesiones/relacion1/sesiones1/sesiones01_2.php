<?php
session_name("sesiones01_1");
session_start();
if (isset($_POST["btnBorrar"])){
    session_destroy();
    header("Location: sesiones01_1.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Nombre 1 (Resultado)</title>
</head>
<body>
    <?php
    if ((isset($_POST["nombre"]) && $_POST["nombre"] != "") || isset($_SESSION["nombre"])){
        $_SESSION["nombre"] = isset($_POST["nombre"]) ? $_POST["nombre"]:$_SESSION["nombre"];
        print "<p>Su nombre es: <strong>".$_SESSION["nombre"]."</strong></p>";
    } else {
        print "<p>En primera página no has tecleado nada.</p>";
    }
    ?>
    <p><a href="sesiones01_1.php">Volver a la primera página.</a></p>
</body>
</html>