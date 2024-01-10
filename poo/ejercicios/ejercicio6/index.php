<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO - Ejercicio6</title>
</head>
<body>
    <h2>POO - Ejercicio6</h2>
    <?php
    require "class_menu.php";
    $menu = new Menu();
    $menu->cargar("https://www.marca.com", "Marca");
    $menu->cargar("https://www.google.com", "Google");
    $menu->cargar("https://www.maralboran.eu", "Alboran");

    print "<h2>Menú horizontal</h2>";
    $menu->imprimirHorizontal();
    print "<h2>Menú vertical</h2>";
    $menu->imprimirVertical();
    ?>
</body>
</html>