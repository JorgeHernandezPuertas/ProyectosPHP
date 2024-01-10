<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO - Ejercicio1</title>
</head>
<body>
<h2>POO - Ejercicio1</h2>
    <?php
    require "class_fruta.php";
    // Creo una instancia de fruta
    $fruta = new Fruta();
    $fruta->setColor("rojo");
    $fruta->setTamanio("3kg");
    print "<p>La fruta es de color ".$fruta->getColor()." y tiene un tamaño de ".$fruta->getTamanio()."</p>";
    ?>
</body>
</html>