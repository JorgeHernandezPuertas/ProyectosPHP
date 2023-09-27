<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 18</title>
</head>
<body>
    <?php
        $deportes = array("futbol", "baloncesto", "natacion", "tenis");
        echo "<p>El total de valores que contienes es: ".count($deportes)."</p>";

        reset($deportes);
        echo "<p>El valor actual es: ".current($deportes)."</p>";

        next($deportes);
        echo "<p>El valor actual es: ".current($deportes)."</p>";

        end($deportes);
        echo "<p>El ultimo valor es: ".current($deportes)."</p>";

        prev($deportes);
        echo "<p>El valor actual es: ".current($deportes)."</p>";

    ?>
</body>
</html>