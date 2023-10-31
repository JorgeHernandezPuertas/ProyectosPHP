<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 6</title>
</head>
<body>
    <?php
        $ciudades = array ("Madrid", "Barcelona", "Londres", "New York", "Los Ángeles", "Chicago");
        foreach($ciudades as $indice => $ciudad){
            echo "<p>La ciudad con el indice $indice tiene el nombre $ciudad</p>";
        }
    ?>
</body>
</html>