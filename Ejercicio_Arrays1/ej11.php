<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 11</title>
</head>
<body>
    <?php
        $animales = array("Lagartija", "Araña", "Perro", "Gato", "Ratón");
        $numeros = array("12", "34", "45", "52", "12");
        $combo = array("Sauce", "Pino", "Naranjo", "Chopo", "Perro", "34");

        $final = array_merge($animales, $numeros, $combo);

        foreach($final as $i => $v){
            echo "<p>$v</p>";
        }
    ?>
</body>
</html>