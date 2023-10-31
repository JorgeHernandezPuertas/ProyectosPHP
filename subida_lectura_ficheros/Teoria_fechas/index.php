<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria Fechas</title>
</head>
<body>
    <h1>Teoría de Fechas</h1>
    <?php
    echo "<p>El tiempo es segundos desde el 1 de Enero de 1970 es: ".time()." segundos</p>";

    echo "<p>Hoy es la fecha: ".date("d/m/Y h:i:s")."</p>";

    if (checkdate(2, 28, 2023)){
        echo "<p>Fecha Buena</p>";
    } else {
        echo "<p>Fecha Mala</p>";
    }

    // El mktime() te da los segundos pasados desde el 1/1/1970 hasta la fecha que das como parametro
    echo "<p>".date("d/m/Y", mktime(0,0,0,9,23,1979))."</p>";

    // El strtotime() hace lo mismo que el mktime() pero con un string de una fecha en buen formato
    echo "<p>".date("d/m/Y", strtotime("09/23/1976"))."</p>";

    // sprintf() te devuelve el string generado que haria ese printf()
    for ($i=1; $i <= 20; $i++) {
        printf("<p>%02d</p>", $i);
    }
    ?>
</body>
</html>