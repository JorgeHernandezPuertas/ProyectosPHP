<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 9</title>
    <style>table, tr, td, th {border:1px solid black;border-collapse: collapse;}</style>
</head>
<body>
    <?php
        $lenguajes_cliente = array("A1" => "JavaScript", "A2" => "HTML");
        $lenguajes_servidor = array("B1" => "PHP", "B2" => "Java", "B3" => "Algo");
        $lenguajes = $lenguajes_cliente;

        
        foreach($lenguajes_servidor as $i => $lenguaje){
            $lenguajes[$i] = $lenguaje;
        }

        echo "<table><tr><th>Lenguajes</th></tr>";
        foreach($lenguajes as $i => $lenguaje){
            echo "<tr><td>".$lenguaje."</td></tr>";
        }
        echo "</table";
    ?>
</body>
</html>