<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 19</title>
</head>
<body>
    <?php
        $ciudades = array("Madrid" => array("amigo1" => array("nombre" => "Pedro", "edad" => 32, "telefono" => "91-999.99.99"), "amigo2" => array("nombre" => "Manolo", "edad" => 36, "telefono" => "91-949.99.99"),
        "amigo3" => array("nombre" => "Cristobal", "edad" => 22, "telefono" => "2134")), "Barcelona" => array("amigo1" => array("nombre" => "Pablo", "edad" => 24, "telefono" => "1241234"), "amigo2" => array("nombre" => "Dario", "edad" => 15, "telefono" => "73456234")), 
        "Toledo" => array("amigo1" => array("nombre" => "Pepito", "edad" => 22, "telefono" => "746345"), "amigo2" => array("nombre" => "Juan", "edad" => 29, "telefono" => "83456"),
        "amigo3" => array("nombre" => "Cristina", "edad" => 23, "telefono" => "66437345")));

        foreach($ciudades as $ciudad => $amigos){
            echo "<p>En $ciudad:<ol>";
            foreach($amigos as $amigo => $datos){
                echo "<li>";
                foreach($datos as $dato => $valor){
                    echo "$dato: $valor ";
                }
                echo "</li>";
            }
            echo "</ol></p>";
        }

    ?>
</body>
</html>