
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>PRIMER LOGIN - Control Tiempo</h2>

    <p><?php print $_SESSION["tiempo_cumplido"] ?></p>
    <?php
    session_destroy();
    ?>
</body>

</html>