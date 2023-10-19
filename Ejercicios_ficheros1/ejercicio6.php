<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6 - Ficheros</title>
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
    <h1>Ejercicio 6 - Ficheros</h1>
    <h3>Información sobre el PIB per cápita de los países de Europa</h3>
    <?php
    @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
    if (!$fd) {
        die("<p>No se ha podido conectar con los datos.</p>");
    }

    fgets($fd); // Me salto la primera fila
    $iniciales;
    while ($linea = fgets($fd)) {
        $array_elementos = explode("\t", $linea);
        $array_primer_elemento = explode(",", $array_elementos[0]);
        $iniciales[] = end($array_primer_elemento);
    }

    fclose($fd);

    ?>
    <form action="ejercicio6.php" method="post">
        <p>
            <label for="inicial">Elige el país que quieras: </label>
            <select name="inicial" id="inicial">
                <?php
                foreach ($iniciales as $v) {
                    if (isset($_POST["btnEnviar"]) && $_POST["inicial"] == $v) {
                        print "<option selected >$v</option>";
                    } else {
                        print "<option>$v</option>";
                    }
                }
                ?>
            </select>
        </p>
        <button type="submit" name="btnEnviar">Buscar</button>
    </form>
    <?php

    if (isset($_POST["btnEnviar"])) {

        // Pongo el puntero del lector al inicio
        @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt" ,"r");
        if (!$fd) {
            die("<p>No se ha podido conectar con los datos.</p>");
        }

        print "<table>";

        // Imprimo la cabecera
        $linea = fgets($fd);
        $array_elementos = explode("\t", $linea);
        $n_col = count($array_elementos);
        foreach ($array_elementos as $k => $v) {
            if ($k == 0) {
                $array_inicial = explode(",", $array_elementos[0]);
                $inicial_primero = end($array_inicial);
                print "<th>$inicial_primero</th>";
            } else {
                print "<th>$v</th>";
            }
        }


        while ($linea = fgets($fd)) {
            // Separo cada elemento de la linea
            $array_elementos = explode("\t", $linea);
            $array_inicial = explode(",", $array_elementos[0]);
            $inicial_actual = end($array_inicial);

            // Si es la cabecera o la inicial seleccionada la imprimo
            if ($_POST["inicial"] == $inicial_actual) {
                // Abro la fila de la tabla
                print "<tr>";
                // Pongo los elementos en la fila
                for ($i = 0; $i < $n_col; $i++) {
                    if ($i == 0) {
                        print "<th>$inicial_actual</th>";
                    } else if (isset($array_elementos[$i])) {
                        print "<td>".$array_elementos[$i]."</td>";
                    } else {
                        print "<td></td>";
                    }
                }
                // Cierro la fila
                print "</tr>";
            }
        }
        print "</table>";

        fclose($fd);
    }


    ?>
</body>

</html>