<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio Arrays 1</title>
</head>
<body>
    <?php
        // Creo el array
        for($i = 0; $i < 10; $i++){
            $numeros[] = $i * 2;
        }
        // Imprimo los numeros
        foreach($numeros as $numero) { 
            echo "<p>$numero</p>";
        }
    ?>
</body>
</html>