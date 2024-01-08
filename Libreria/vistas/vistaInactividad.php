<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inactividad</title>
</head>
<body>
    <h2>Has superado el tiempo de inactividad de nuestra página web</h2>
    <?php
    print "<p>".$_SESSION["mensajeInactivo"]."</p>";
    unset($_SESSION["mensajeInactivo"]);
    ?>
</body>
</html>