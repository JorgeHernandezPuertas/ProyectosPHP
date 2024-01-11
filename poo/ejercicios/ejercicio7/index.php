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
    require "class_pelicula.php";
    $pelicula = new Pelicula("Gladiator", "Director1", 1999, 12.5, true, "01/10/2024");

    print "<h2>Datos de la película</h2>";
    print "<p><strong>Nombre:</strong> ".$pelicula->getNombre()."</p>";
    print "<p><strong>Año:</strong> ".$pelicula->getAnio()."</p>";
    print "<p><strong>Director:</strong> ".$pelicula->getDirector()."</p>";
    print "<p><strong>Precio:</strong> ".$pelicula->getPrecio()."</p>";
    print "<p><strong>Está alquilada:</strong> ".($pelicula->getAlquilada() ? "Sí":"No")."</p>";
    print "<p><strong>Fecha prevista de devolución:</strong> ".$pelicula->getFechaPrevDevolucion()."</p>";
    print "<p><strong>Recargo por atraso:</strong> ".$pelicula->calcularRecargo()."€</p>";
    ?>
</body>
</html>