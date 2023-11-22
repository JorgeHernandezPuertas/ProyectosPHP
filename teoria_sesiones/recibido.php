<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibido</title>
</head>
<body>
    <h1>Recibido</h1>
    <p>Nombre: <?php print $_SESSION["nombre"] ?></p>
    <p>Clave: <?php print $_SESSION["clave"] ?></p>
    <p><a href="index.php">Ir a index</a></p>
    <?php
    $_SESSION["nombre"] = "Dario jeje";
    $_SESSION["clave"] = md5("gfhh");
    ?>
</body>
</html>