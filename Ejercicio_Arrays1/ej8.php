<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio arrays 8</title>
</head>
<body>
    <?php
        $nombres = array("Pedro", "Ismael", "Sonia", "Clara", "Susana", "Alfonso", "Teresa");
        echo "<p>El array contiene ".count($nombres)." elementos</p><ol>";
        foreach($nombres as $v){
            echo "<li>$v</li>";
        }
        echo "</ol>";
    ?>
</body>
</html>