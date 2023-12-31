<?php
require "funciones.php";

if (file_exists("Horario/horarios.txt")) {

    @$fd = fopen("Horario/horarios.txt", "r");
    if (!$fd) {
        die("<p>No se ha podido leer el archivo</p>");
    }

    while ($linea = fgets($fd)) {
        $array_linea = mi_explode("\t", $linea);
        $profesor = $array_linea[0];
        $profesores[] = $profesor;
        if (isset($_POST["btnEnviar"]) && $_POST["profesor"] == $profesor) {
            $elementos_elegidos = $array_linea;
        }
    }

    fclose($fd);

?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Practica examen 1 - Ejercicio 4</title>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                text-align: center;
            }

            th, td {
                padding: 0.25em;
            }

            th {
                background-color: lightgray;
            }
        </style>
    </head>

    <body>
        <h1>Ejercicio 4</h1>
        <h2>Horario de los Profesores</h2>
        <form action="ejercicio4.php" method="post">
            <label for="profesor">Horario del Profesor: </label>
            <select name="profesor" id="profesor">
                <?php
                foreach ($profesores as $profesor) {
                    if (isset($_POST["btnEnviar"]) && $_POST["profesor"] == $profesor) {
                        print "<option value='$profesor' selected >$profesor</option>";
                    } else {
                        print "<option value='$profesor' >$profesor</option>";
                    }
                }
                ?>
            </select>
            <button name="btnEnviar">Ver horario</button>
        </form>
        <?php
        if (isset($_POST["btnEnviar"])) {
            print "<table><caption><strong>Horario del profesor: <em>" . $_POST["profesor"] . "</em></strong></caption>";
            $n_col = count($elementos_elegidos);
            // Pongo la cabecera
            $dias = array("", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes");
            print "<tr>";
            for ($i = 0; $i < 6; $i++) {
                print "<th>".$dias[$i]."</th>";
            }
            print "</tr>";

            // Pongo por horas
            $horas = array(1 => "8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45");
            foreach($horas as $indice_hora => $hora){
                print "<tr>";
                if ($indice_hora == 4){
                    print "<th>$hora</th>";
                    print "<td colspan='5'>RECREO</td>";
                } else {
                    foreach ($dias as $indice_dia => $dia) {
                        if ($dia == ""){
                            print "<th>$hora</th>";
                        } else {
                            $clases_dia_hora = "";
                            foreach($elementos_elegidos as $indice => $elemento){
                                if (($indice - 1) % 3 == 0 && $elemento == $indice_dia && $elementos_elegidos[$indice + 1] == $indice_hora){
                                    $clases_dia_hora .= $elementos_elegidos[$indice + 2]."/";
                                }
                            }
                            $clases_dia_hora = quitarElemento($clases_dia_hora, mi_strlen($clases_dia_hora) - 1); // Le quito la última "/"
                            print "<td>$clases_dia_hora</td>";
                        }
                    }
                }
                print "</tr>";
            }

            print "</table>";
        }
        ?>
    </body>

    </html>
<?php
} else {
    if (isset($_POST["btnEnviar"])) {
        $error_form = $_FILES["fichero"]["name"] == "" || $_FILES["fichero"]["error"] || $_FILES["fichero"]["type"] != "text/plain" || $_FILES["fichero"]["size"] > 1024 * 1024;
    }
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Practica examen 1 - Ejercicio 4</title>
        <style>
            .error {
                color: red
            }
        </style>
    </head>

    <body>
        <h1>Ejercicio 4</h1>
        <h2>No se encuentra el archivo Horario/horarios.txt</h2>
        <form action="ejercicio4.php" method="post" enctype="multipart/form-data">
            <p>
                <label for="fichero">Sube un fichero txt (Máx. 1MB): </label>
                <input type="file" name="fichero" id="fichero" accept=".txt">
                <?php
                if (isset($_POST["btnEnviar"]) && $error_form) {
                    if ($_FILES["fichero"]["name"] == "") {
                        print "<span class='error'> *No se ha enviado ningún archivo* </span>";
                    } else if ($_FILES["fichero"]["error"]) {
                        print "<span class='error'> *Ha ocurrido un error subiendo el archivo* </span>";
                    } else {
                        print "<span class='error'> *El tamaño del archivo es superior a 1MB* </span>";
                    }
                }
                ?>
            </p>
            <button type="submit" name="btnEnviar">Enviar</button>
        </form>
        <?php
        if (isset($_POST["btnEnviar"]) && !$error_form) {
            $ruta = "Horario/horarios.txt";
            @$var = move_uploaded_file($_FILES["fichero"]["tmp_name"], $ruta);
            if (!$var) {
                die("<p class='error'>No se ha podido subir el archivo.</p>");
            }

            print "<p>Se ha subido el archivo con éxito</p>";
        }
        ?>


    </body>

    </html>
<?php
}
?>