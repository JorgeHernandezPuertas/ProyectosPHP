<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title></title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <?php
        echo "<h1>Mi primera página Curso 23-24</h1>";
        // Asi se declaran variables
        $var1 = 8;
        $var2 = 9;
        $var3 = $var2 + $var1;

        // Así se concatenan strings (con el punto)
        echo "<p>El resultado es: " . $var3 . "</p>";
        echo "<p>El resultado de ".$var1." más ".$var2." es: ".$var3."</p>";

        // Así se condiciona (el "else if" es como en java, ifs anidados)
        if (3 > $var3){
            echo "<p>3 es mayor que ".$var3."</p>";
        } else if (3 == $var3){
            echo "<p>3 es igual que ".$var3."</p>";
        } else {
            echo "<p>3 es menor que ".$var3."</p>";
        }

        // El switch es asi (aún no han metido el switch con flechas, lo quieren meter en la versión 8.x)
        switch($var3 < 1){
            case 1: $var3 = $var1 - $var2;
            break;
            case 2: $var3 = $var1 / $var2;
            break;
            case 3: $var3 = $var1 * $var2;
            break;
            default: $var3 = $var1 + $var2;
            break;
        }
        echo "<p>El resultado del  switch es: ".$var3."</p>";

        // Así es el bucle for
        echo "<h3>Bucle for:</h3>";
        for($i = 0;$i < 8;$i++){
            echo "<p>Hola número ".($i + 1)."</p>";
        }

        // Así es el bucle while
        echo "<h3>Bucle while:</h3>";
        $control = 0;
        while ($control < 8){
            echo "<p>Hola número ".($control + 1)."</p>";
            $control++;
        }
    ?>
</body>
</html>