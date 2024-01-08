<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Has sido baneado</title>
</head>
<body>
    <h2>Has sido baneado de nuestra página web</h2>
    <?php
    print "<p>".$_SESSION["mensajeBaneado"]."</p>";
    unset($_SESSION["mensajeBaneado"]);
    ?>
</body>
</html>