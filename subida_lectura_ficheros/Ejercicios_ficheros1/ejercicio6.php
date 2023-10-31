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

    // Cojo la primera fila
    $linea_cabecera = fgets($fd); 
    $elementos_cabecera = explode("\t", $linea_cabecera);

    while ($linea = fgets($fd)) {
        $array_elementos = explode("\t", $linea);
        $array_primer_elemento = explode(",", $array_elementos[0]);
        $iniciales[] = end($array_primer_elemento);
        if (isset($_POST["btnEnviar"]) && $_POST["inicial"] == end($array_primer_elemento)) {
            $datos_elegidos = $array_elementos;
        }
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
                        print "<option value='$v' selected >$v</option>";
                    } else {
                        print "<option value='$v'>$v</option>";
                    }
                }
                ?>
            </select>
        </p>
        <button type="submit" name="btnEnviar">Buscar</button>
    </form>
    <?php

    if (isset($_POST["btnEnviar"])) {

        print "<table>";

        // Imprimo la cabecera
        $n_col = count($elementos_cabecera);

        // Abro la fila para la cabecera
        print "<tr>";
        foreach ($elementos_cabecera as $k => $v) {
            if ($k == 0) {
                $array_inicial = explode(",", $elementos_cabecera[0]);
                $inicial_primero = end($array_inicial);
                print "<th>$inicial_primero</th>";
            } else {
                print "<th>$v</th>";
            }
        }
        // Cierro la fila
        print "</tr>";

                // Abro la fila para el pais seleccionado
                print "<tr>";
                // Pongo los elementos en la fila
                for ($i = 0; $i < $n_col; $i++) {
                    if ($i == 0) {
                        $elementos_primera_col = explode(",", $datos_elegidos[0]);
                        $inicial_actual = end($elementos_primera_col);
                        print "<th>$inicial_actual</th>";
                    } else if (isset($datos_elegidos[$i])) {
                        print "<td>".$datos_elegidos[$i]."</td>";
                    } else {
                        print "<td></td>";
                    }
                }
                // Cierro la fila
                print "</tr>";
        print "</table>";

    }


    ?>
</body>

</html>