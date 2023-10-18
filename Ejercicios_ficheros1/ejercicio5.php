<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5 - Ficheros</title>
    <style>
        table,
        td,
        tr,
        th {
            border: 1px black solid;
            border-collapse: collapse;
            text-align: center;
        }

        table {
            margin-top: 1em;
        }

        td,
        th {
            padding: 0.25em
        }
    </style>
</head>

<body>
    <h1>Ejercicio 5 - Ficheros</h1>
    <h3>Información sobre el PIB per cápita de los países de Europa</h3>
    <?php
    @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
    if (!$fd) {
        die("<p>No se ha podido leer el fichero.</p>");
    }


    print "<table>";

    // Pongo la primera línea como cabecera
    $linea = fgets($fd);
    $array_elementos = explode("\t", $linea);
    $n_col = count($array_elementos);
    print "<tr>";
    foreach ($array_elementos as $k => $v) {
        if ($k == 0) {
            $array_iniciales = explode(",", $v);
            $inicial = end($array_iniciales);
            print "<th>$inicial</th>";
        } else {
            print "<th>$v</th>";
        }
    }
    print "</tr>";

    while ($linea = fgets($fd)) {
        // Separo cada elemento de la linea
        $array_elementos = explode("\t", $linea);
        // Abro la fila de la tabla
        print "<tr>";
        // Pongo los elementos en la fila
        for ($i = 0; $i < $n_col; $i++) { // Uso $n_col para que no queden columnas sin poner en caso de que no haya datos
            if ($i == 0) {
                $array_iniciales = explode(",", $array_elementos[$i]);
                $inicial = end($array_iniciales);
                print "<th>$inicial</th>";
            } else if (isset($array_elementos[$i])) {
                print "<td>".$array_elementos[$i]."</td>";
            } else {
                print "<td></td>";
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