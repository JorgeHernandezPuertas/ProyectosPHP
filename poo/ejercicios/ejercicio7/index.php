<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO - Ejercicio7</title>
</head>
<body>
    <h2>POO - Ejercicio7</h2>
    <?php
    require "class_menu.php";
    $menu = new Menu("BraveShave", "BraveShave@gmail.com", "Más información");

    print "<h2>Menú horizontal</h2>";
    $menu->imprimirHorizontal();
    print "<h2>Menú vertical</h2>";
    $menu->imprimirVertical();
    ?>
</body>
</html>