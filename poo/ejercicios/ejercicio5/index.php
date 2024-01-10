<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO - Ejercicio5</title>
</head>
<body>
    <h2>POO - Ejercicio5</h2>
    <?php
    require "class_empleado.php";
    $empleado1 = new Empleado("Jorge", 5000);
    $empleado2 = new Empleado("Dario", 1000);

    print "<h2>Empleados y su compromiso con hacienda</h2>";
    $empleado1->imprimir();
    $empleado2->imprimir();
    ?>
</body>
</html>