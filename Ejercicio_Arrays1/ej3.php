<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 3</title>
</head>
<body>
    <?php
        $meses = array("enero" => 9, "febrero" => 12, "marzo" => 0, "abril" => 17);
        foreach($meses as $mes => $pelis){
            if ($pelis > 0){
                echo "<p>En $mes se han visto $pelis peliculas</p>";
            }
        }
    ?>
</body>
</html>