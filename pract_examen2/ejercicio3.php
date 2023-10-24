<?php
require "funciones.php";
if (isset($_POST["btnEnviar"])) {
    $error_form = $_POST["palabra"] == "";
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3 - Practica éxamen 2</title>
    <style>
        .error {
            color: red
        }
    </style>
</head>

<body>
    <h2>Ejercicio 3 - Practica éxamen 2</h2>
    <form action="ejercicio3.php" method="post">
        <p>
            <label for="palabra">Introduce una frase para separar: </label>
            <input type="text" name="palabra" id="palabra" value="<?php if (isset($_POST["palabra"])) print $_POST["palabra"] ?>">
            <?php
            if (isset($_POST["btnEnviar"]) && $error_form) {
                print "<span class='error'> *Campo obligatorio* </span>";
            }
            ?>
        </p>
        <p>
            <select name="separador" id="separador">
                <option value="/" <?php if (isset($_POST["separador"]) && $_POST["separador"] == "/")  print "selected" ?>>/</option>
                <option value=" " <?php if (isset($_POST["separador"]) && $_POST["separador"] == " ") print "selected" ?>>espacio</option>
                <option value="\t" <?php if (isset($_POST["separador"]) && $_POST["separador"] == "\\t") print "selected" ?>>tab</option>
                <option value="-" <?php if (isset($_POST["separador"]) && $_POST["separador"] == "-") print "selected" ?>>-</option>
                <option value=";" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ";") print "selected" ?>>;</option>
                <option value="." <?php if (isset($_POST["separador"]) && $_POST["separador"] == ".") print "selected" ?>>.</option>
                <option value="," <?php if (isset($_POST["separador"]) && $_POST["separador"] == ",") print "selected" ?>>,</option>
                <option value=":" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ":") print "selected" ?>>:</option>
            </select>
        </p>
        <button type="submit" name="btnEnviar">Separar</button>

    </form>
    <?php
    if (isset($_POST["btnEnviar"]) && !$error_form) {
        $cont = 0;
        $explotado = mi_explode($_POST["separador"], $_POST["palabra"]);
        foreach ($explotado as $v) {
            if ($v != "") {
                $cont++;
            }
        }

        if ($cont == 0) {
            print "<p>No has introducido ninguna palabra.</p>";
        } else if ($cont <= 1) {
            print "<p>Has introducido 1 palabra.</p>";
        } else {
            print "<p>Has introducido $cont palabras.</p>";
        }
    }


    ?>
</body>

</html>