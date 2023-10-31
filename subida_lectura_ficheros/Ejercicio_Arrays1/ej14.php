<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ejercicio arrays 14</title>
    <style>table, th, td, tr {border:1px solid black;border-collapse: collapse;}</style>
</head>
<body>
    <?php
    $estadios_futbol = array("Barcelona" => "Camp Nou", "Real Madrid" => "Santiago Bernabeu", "Valencia" => "Mestalla", "Real Sociedad" => "Anoeta");
    
    echo "<table><tr><th>Equipos</th><th>Estadios</th></tr>";
    foreach($estadios_futbol as $i => $v){
        echo "<tr><td>$i</td><td>$v</td></tr>";
    }
    echo "</table>";

    unset($estadios_futbol["Real Madrid"]);

    echo "<p>Estadios<ol>";
    foreach($estadios_futbol as $i => $v){
        echo "<li>$v</li>";
    }
    echo "</ol></p>"

    ?>
</body>
</html>