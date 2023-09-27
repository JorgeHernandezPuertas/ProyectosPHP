<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 17</title>
</head>
<body>
    <?php
        $familias = array("Los Simpson" => array("Padre" => "Homer", "Madre" => "Marge", "Hijos" => array("Bart", "Lisa", "Maggie")),
        "Los Griffin" => array("Padre" => "Peter", "Madre" => "Lois", "Hijos" => array("Chris", "Meg", "Stewie")));

        echo "<ul>";
        foreach($familias as $familia => $componentes){
            echo "<li>$familia<ul>";
            foreach($componentes as $cargo => $nombre){
                if ($cargo == "Hijos"){
                    echo "<li>$cargo: <ul>";
                    foreach($nombre as $v){
                        echo "<li>$v</li>";
                    }
                    echo "</ul></li>";
                } else {
                    echo "<li>$cargo: $nombre</li>";
                }
            }
            echo "</ul></li>";
        }
        echo "</ul>";
    ?>
</body>
</html>