<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO - Ejercicio4</title>
</head>
<body>
    <h2>POO - Ejercicio4</h2>
    <?php
    require "class_uva.php";
    // Creo una uva
    $uva = new Uva("verde", "pequeña", true);
    $texto = $uva->tieneSemilla() ? "La uva tiene semilla":"La uva no tiene semilla";

    print "<h2>Información de mi uva</h2>";

    print $uva->imprimir();

    print "<p>$texto</p>";
    
    ?>
</body>
</html>