<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 10</title>
</head>
<body>
    <h2>Array con los primeros 10 naturales</h2>
    <?php
        for ($i=0; $i < 10; $i++) { 
            $array[] = $i + 1;
        }

        $total = 0;
        $contador = 0;
        foreach($array as $i => $v){
            if ($v % 2 == 0){
                $total += $v;
                $contador++;
            } else {
                echo "<p>$v</p>";
            }
        }
        echo "<p>La media de los pares es: ".$total/$contador."</p>";

    ?>
</body>
</html>