<?php
if (isset($_POST["btnEnviar"])) {
    $error_form = $_POST["num"] == "" || !is_numeric($_POST["num"]) || strlen($_POST["num"]) > 2 || $_POST["num"] < 1 || $_POST["num"] > 10;
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2 - Ficheros</title>
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
    <h1>Ejercicio 2 - Ficheros</h1>
    <form action="ejercicio2.php" method="post">
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
        if (file_exists("Tablas/$nombre_fichero")) {
            if ($datos_fichero = file_get_contents("Tablas/$nombre_fichero")) {
                $datos_a_html = nl2br($datos_fichero);
                print "<p>La tabla del ".$_POST["num"]." es:<br>";
                print "$datos_a_html</p>";
            } else {
                die("<p class='error'>No se ha podido leer el fichero Tablas/$nombre_fichero.txt");
            }
        } else {
            print "<p class='error'>EL fichero no existe</p>";
        }
    }
    ?>


</body>

</html>