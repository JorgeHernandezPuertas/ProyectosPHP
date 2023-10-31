<?php
if (isset($_POST["btnEnviar"])) {
    $error_num1 = $_POST["num1"] == "" || !is_numeric($_POST["num1"]) || strlen($_POST["num1"]) > 2 || $_POST["num1"] < 1 || $_POST["num1"] > 10;
    $error_num2 = $_POST["num2"] == "" || !is_numeric($_POST["num2"]) || strlen($_POST["num2"]) > 2 || $_POST["num2"] < 1 || $_POST["num2"] > 10;

    $error_form = $error_num1 || $error_num2;
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3 - Ficheros</title>
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
    <h1>Ejercicio 3 - Ficheros</h1>
    <form action="ejercicio3.php" method="post">
        <p>
            <label for="num1">Introduce un número entre 1 y 10 (ambos inclusive): </label>
            <input type="text" name="num1" id="num1" value="<?php if (isset($_POST["num1"])) print $_POST["num1"] ?>">
            <?php
            if (isset($_POST["btnEnviar"]) && $error_num1) {
                if ($_POST["num1"] == "") {
                    print "<span class='error'> *Campo vacio* </span>";
                } else {
                    print "<span class='error'> *Error: No has introducido un número correcto.* </span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="num2">Introduce un número entre 1 y 10 (ambos inclusive): </label>
            <input type="text" name="num2" id="num2" value="<?php if (isset($_POST["num2"])) print $_POST["num2"] ?>">
            <?php
            if (isset($_POST["btnEnviar"]) && $error_num2) {
                if ($_POST["num2"] == "") {
                    print "<span class='error'> *Campo vacio* </span>";
                } else {
                    print "<span class='error'> *Error: No has introducido un número correcto.* </span>";
                }
            }
            ?>
        </p>
        <button type="submit" name="btnEnviar">Enviar</button>
    </form>
    <?php
    if (isset($_POST["btnEnviar"]) && !$error_form) {
        $nombre_fichero = "tabla_" . $_POST["num1"] . ".txt";
        if (file_exists("Tablas/$nombre_fichero")) {
            @$fd = fopen("Tablas/$nombre_fichero", "r");
            if (!$fd) {
                die("<p class='error'>No se ha podido leer el fichero Tablas/$nombre_fichero.txt");
            }

            $contador = 1;
            while($linea = fgets($fd)){
                if ($contador == $_POST["num2"]){
                    print "<p>La linea " . $_POST["num2"] . " es: $linea</p>";
                    break;
                }
                $contador++;
            }

            fclose($fd);
        } else {
            print "<p class='error'>El fichero no existe</p>";
        }
    }
    ?>


</body>

</html>