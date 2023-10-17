<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6 - Ficheros</title>
    <style>
        table, td, tr {border:1px black solid; border-collapse: collapse;}
    </style>
</head>
<body>
    <h1>Ejercicio 6 - Ficheros</h1>
    <h3>Información sobre el PIB per cápita de los países de Europa</h3>
    <form action="ejercicio6.php" method="post">
        <p>
            <label for="inicial">Introduce las iniciales del país que quieras: </label>
            <input type="text" name="inicial" id="inicial" value="<?php if (isset($_POST["inicial"])) print $_POST["inicial"] ?>">
        </p>
        <button type="submit" name="btnEnviar">Buscar</button>
    </form>
    <?php

    if (isset())

    @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
    if (!$fd){
        die("<p>No se ha podido leer el fichero.</p>");
    }

    $inicial = strtoupper($_POST["inicial"]);

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