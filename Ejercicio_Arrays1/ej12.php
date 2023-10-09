<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios arrays 12</title>
</head>
<body>
    <?php

        $animales = array("Lagartija", "Araña", "Perro", "Gato", "Ratón");
        $numeros = array("12", "34", "45", "52", "12");
        $combo = array("Sauce", "Pino", "Naranjo", "Chopo", "Perro", "34");

        $final = [];
        foreach($animales as $i => $v){
            array_push($final, $v);
        }

        foreach($numeros as $i => $v){
            array_push($final, $v);
        }

        foreach($combo as $i => $v){
            array_push($final, $v);
        }

        foreach($final as $i => $v){
            echo "<p>$v</p>";
        }
    ?>
</body>
</html>