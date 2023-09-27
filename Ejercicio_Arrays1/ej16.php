<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 16</title>
</head>
<body>
    <?php
        $array = array(5 => 1, 12 => 2, 13 => 56, "x" => 42);
        echo "<p>";
        foreach($array as $v){
            echo "$v ";
        }
        echo "</p>";

        $contador = 0;
        foreach($array as $v){
            $contador++;
        }
        echo "<p>Tiene $contador elementos.</p>";

        unset($array[5]);

        echo "<p>";
        foreach($array as $v){
            echo "$v ";
        }
        echo "</p>";

        unset($array);
    ?>
</body>
</html>