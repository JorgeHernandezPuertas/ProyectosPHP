<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría de String</title>
</head>
<body>
    <?php
        $str1 = "Hola";
        $str2 = "Juan";

        echo "<h1>".$str1." ".$str2."</h2>";

        // Principales funciones para strings
        $longitud1 = strlen($str2); // La función count no funciona, da error
        echo "<p>La longitud del string '$str1' es: $longitud1</p>";

        $a = $str1[3];

        // Para poner todo es mayusculas strtoupper() y para minúsculas strtolower()
        echo "<p>$str1</p>";
        echo "<p>".strtoupper($str1)."</p>"; // No cambia la variable, simplemente la devuelve en mayusculas
        echo "<p>$str1</p>";

        // Para limpiar espacios a los lados existe trim()

        // Para partir un string en partes se usa explode(delimitador, strPartido)
        $prueba = "loquesea.jpg";
        $sep_arr = explode(".", $prueba);
        print_r($sep_arr);
        echo "<p>Archivo leído es: $prueba</p>";
        echo "<p>Extensión leída es: ".end($sep_arr)."</p>";

        // El implode(delimitador, arr) te convierte el array en un string
        $arr_prueba = array("hola", "Juan", "Antonio", "María");
        print_r($arr_prueba);
        $str3 = implode(":::", $arr_prueba);
        echo "<p>El array convertido en string es: '$str3'</p>";

        // La función substr(str, indice, pos) te devuelve un substring partiendo del indice y de la longitud puesta

        

    ?>
</body>
</html>