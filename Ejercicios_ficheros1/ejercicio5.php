<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5 - Ficheros</title>
    <style>
        table, td, tr {border:1px black solid; border-collapse: collapse;}
    </style>
</head>
<body>
    <h1>Ejercicio 5 - Ficheros</h1>
    <h3>Información sobre el PIB per cápita de los países de Europa</h3>
    <?php
    @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
    if (!$fd){
        die("<p>No se ha podido leer el fichero.</p>");
    }


    print "<table>";

    while($linea = fgets($fd)) {
        // Separo cada elemento de la linea
        $array_elementos = explode("\t", $linea);
        // Abro la fila de la tabla
        print "<tr>";
        // Pongo los elementos en la fila
        foreach($array_elementos as $k => $v){
            if ($k == 0){
                print "<th>$v</th>";
            } else {
                print "<td>$v</td>";
            }
        }
        // Cierro la fila
        print "</tr>";
    }
    print "</table>";

        fclose($fd);
    ?>
</body>
</html>