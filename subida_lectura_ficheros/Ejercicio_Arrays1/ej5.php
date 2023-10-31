<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 5</title>
</head>
<body>
    <?php
        $persona = array("Nombre" => "Pedro Torres", "Direccion" => "C/ Mayor, 37", "Telefono" => "123456789");
        echo "<p>";
        foreach ($persona as $k => $v) {
            echo "$k: $v <br/>";
        }
        echo "</p>";
    ?>
</body>
</html>