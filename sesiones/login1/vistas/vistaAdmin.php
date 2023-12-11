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
    <h2>PRIMER LOGIN - Vista Admin</h2>

    <?php
    print "<h3>" . $_SESSION["mensaje"] . "</h3>";
    print "<p>Eres el usuario " . $_SESSION["user"] . " con tipo " . $datos_usuario_logeado["tipo"] . "</p>";
    print "<form action='index.php' method='post'><button name='btnSalir'>Salir</button></form>";
    ?>
</body>

</html>