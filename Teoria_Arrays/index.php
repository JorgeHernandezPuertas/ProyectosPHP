<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría Arrays</title>
</head>
<body>
    <?php 
        /*
        $nota[0] = 5;
        $nota[1] = 9;
        $nota[2] = 8;
        $nota[3] = 5;
        $nota[4] = 6;
        $nota[5] = 7;
        */
        $nota = array(5, 9, 8, 5, 6, 7);

        echo "<h1>Recorrido de un array escalar con sus indices correlativos</h1>";
        var_dump($nota);
        echo "<br/>";
        print_r($nota);

        for ($i = 0; $i < count($nota); $i++){
            echo "<p>En la posición: $i tiene el valor:".$nota[$i]."</p>";
        }

        
        
        

        /*
        $valor[0] = 18;
        $valor[1] = "Hola";
        $valor[2] = true;
        $valor[3] = 3.4;
        
        $valor[] = 18;
        $valor[99] = "Hola";
        $valor[] = true; // En las variables booleanas se imprime 1 si es true o nada si es false
        $valor[200] = 3.4;
        */

        $valor = array(18, 99 => "Hola", true, 200 => 3.4);

        echo "<h1>Recorrido de un array escalar con sus indices NO correlativos</h1>";
        var_dump($valor);
        foreach($valor as $k => $v){
            echo "<p>En la posición: $k tiene el valor: $v </p>";
        }
        
        // Despejo la variable $nota
        unset($nota);

        $nota["Antonio"]["DWESE"] = 5;
        $nota["Antonio"]["DWEC"] = 7;
        $nota["Luis"]["DWESE"] = 9;
        $nota["Luis"]["DWEC"] = 7;
        $nota["Ana"]["DWESE"] = 8;
        $nota["Ana"]["DWEC"] = 9;
        $nota["Eloy"]["DWESE"] = 5;
        $nota["Eloy"]["DWEC"] = 5;
        $nota["Gabriela"]["DWESE"] = 6;
        $nota["Gabriela"]["DWEC"] = 3;

        echo "<h1>Notas de DWESE</h1>";
        foreach($nota as $nombre => $asignaturas){
            echo "<p>$nombre<ul>";
            foreach($asignaturas as $asignatura => $nota){
                if ($asignatura == "DWESE"){
                    echo "<li><strong>$asignatura</strong> -> $nota</li>";
                } else {
                    echo "<li><strong>$asignatura</strong> -> $nota</li>";
                }
            }
            echo "</ul></p>";
        }

        // Funciones para recorrer arrays
        echo "<h1>Funciones para recorrer arrays</h1>";
        $capital=array("Castilla y León" => "Valladolid", "Asturias" => "Oviedo", "Aragón" =>" Zaragoza");

        echo "<p>Valor del puntero actual de un array: ". current($capital)."</p>";
        echo "<p>Útimo valor de un array: ". end($capital)."</p>";
        echo "<p>Valor del puntero actual de un array: ". current($capital)."</p>";
        echo "<p>Indice del puntero de un array: ". key($capital)."</p>";
        // Para ir al primero uso:
        reset($capital);
        echo "<p>Valor del puntero actual de un array: ". current($capital)."</p>";
    ?>
</body>
</html>