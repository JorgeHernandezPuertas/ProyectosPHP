<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 15</title>
    <style>table, th, td, tr {border:1px solid black;border-collapse: collapse;}</style>
</head>
<body>
    <?php
        $numeros = array(3, 2, 8, 123, 5, 1);
        sort($numeros);

        echo "<table><tr><th>Numeros</th></tr>";
        foreach($numeros as $v){
            echo "<tr><td>$v</td></tr>";
        }
        echo "</table>";
    ?>
</body>
</html>