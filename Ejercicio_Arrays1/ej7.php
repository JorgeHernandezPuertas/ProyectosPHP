<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 7</title>
</head>
<body>
    <?php
        $ciudades = array ("MD" => "Madrid", "BC" => "Barcelona", "LN" => "Londres", "NY" => "New York", "LA" => "Los Ángeles", "CH" => "Chicago");
        foreach($ciudades as $indice => $ciudad){
            echo "<p>El indice del array que contiene como valor $ciudad es $indice</p>";
        }
    ?>
</body>
</html>