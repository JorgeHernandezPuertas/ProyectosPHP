<?php
if (isset($_POST["btnEnviar"])) {
    $error_form = $_POST["num"] == "" || !is_numeric($_POST["num"]) || strlen($_POST["num"]) <= 2 || $_POST["num"] < 1 || $_POST["num"] > 10;
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1 - Ficheros</title>
    <style>
        .error {
            color: red
        }

        .exito {
            color: green
        }
    </style>
</head>

<body>
    <h1>Ejercicio 1 - Ficheros</h1>
    <form action="ejercicio1.php" method="post">
        <label for="num">Introduce un número entre 1 y 10 (ambos inclusive): </label>
        <input type="text" name="num" id="num" value="<?php if (isset($_POST["num"])) print $_POST["num"] ?>">
        <?php
        if (isset($_POST["btnEnviar"]) && $error_form) {
            if ($_POST["num"] == "") {
                print "<span class='error'> *Campo vacio* </span>";
            } else {
                print "<span class='error'> *Error: No has introducido un número correcto.* </span>";
            }
        }
        ?>
        <br><button type="submit" name="btnEnviar">Enviar</button>
    </form>
    <?php
    if (isset($_POST["btnEnviar"]) && !$error_form) {
        $nombre_fichero = "tabla_" . $_POST["num"] . ".txt";
        if (!file_exists("Tablas/$nombre_fichero")) {
            @$fd = fopen("Tablas/$nombre_fichero", "w");
            if (!$fd) {
                die("<p class='error'>No se ha podido crear el fichero Tablas/$nombre_fichero.txt");
            }



            for ($i = 1; $i <= 10; $i++) {
                fwrite($fd, $_POST["num"] . " X $i = " . ($_POST["num"] * $i) . PHP_EOL);
            }
        }

        print "<p class='exito'>Fichero generado con éxito</p>";

        fclose($fd);
    }
    ?>


</body>

</html>