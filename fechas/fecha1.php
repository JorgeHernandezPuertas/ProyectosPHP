<?php
if (isset($_POST["btnEnviar"])) {
    // Compruebo la fecha1
    $fecha1 = trim($_POST["fecha1"]);
    $error_fecha1_vacia = $fecha1 == "";
    $error_fecha1_formato = !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $fecha1);
    $error_fecha1_posible = false;
    if (!$error_fecha1_formato) {
        $array_fecha1 = explode("/", $fecha1);
        $error_fecha1_posible = !checkdate($array_fecha1[1], $array_fecha1[0], $array_fecha1[2]);
    }
    $error_fecha1 = $error_fecha1_vacia || $error_fecha1_formato || $error_fecha1_posible;

    // Compruebo la fecha2
    $fecha2 = trim($_POST["fecha2"]);
    $error_fecha2_vacia = $fecha2 == "";
    $error_fecha2_formato = !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $fecha2);
    $error_fecha2_posible = false;
    if (!$error_fecha2_formato) {
        $array_fecha2 = explode("/", $fecha2);
        $error_fecha2_posible = !checkdate($array_fecha2[1], $array_fecha2[0], $array_fecha2[2]);
    }
    $error_fecha2 = $error_fecha2_vacia || $error_fecha2_formato || $error_fecha2_posible;

    // Compruebo que no falle ninguna
    $errores = $error_fecha1 || $error_fecha2;
}
?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fecha1</title>
    <style>
        .error {
            color: red
        }

        .azul {
            background: lightblue;
        }

        .verde {
            background: lightgreen;
        }

        div {
            padding: 1em;
            border: 1px solid black;
            margin-bottom: 1em;
        }
    </style>
</head>
<body>
    <div class="azul">
        <h1>Fechas-Formulario</h1>
        <form action="fecha1.php" method="post">
        <p>
            <label for="fecha1">Introduzca una fecha: (DD/MM/YYYY)</label>
            <input type="text" name="fecha1" id="fecha1" value="<?php if (isset($_POST["btnEnviar"]) && !$error_fecha1) echo $_POST["fecha1"] ?>" />
            <?php
            if (isset($_POST["btnEnviar"]) && $error_fecha1_vacia) {
                echo "<span class='error'> *Campo vacio* </span>";
            } else if (isset($_POST["btnEnviar"]) && $error_fecha1_formato) {
                print "<span class='error'> *Error en el formato de la fecha* </span>";
            } else if (isset($_POST["btnEnviar"]) && $error_fecha1_posible) {
                print "<span class='error'> *Esa fecha no existe* </span>";
            }
            ?>
        </p>
        <p>
            <label for="fecha2">Introduzca una fecha: (DD/MM/YYYY)</label>
            <input type="text" name="fecha2" id="fecha2" value="<?php if (isset($_POST["btnEnviar"]) && !$error_fecha2) echo $_POST["fecha2"] ?>" />
            <?php
            if (isset($_POST["btnEnviar"]) && $error_fecha2_vacia) {
                print "<span class='error'> *Campo vacio* </span>";
            } else if (isset($_POST["btnEnviar"]) && $error_fecha2_formato) {
                print "<span class='error'> *Error en el formato de la fecha* </span>";
            } else if (isset($_POST["btnEnviar"]) && $error_fecha2_posible) {
                print "<span class='error'> *Esa fecha no existe* </span>";
            }
            ?>
        </p>
        <p>
            <input type="submit" name="btnEnviar" value="Calcular" />
        </p>
        </form>
    </div>
    <?php
    if (isset($_POST["btnEnviar"]) && !$errores){
        
        $segundos1 = strtotime($array_fecha1[1]."/".$array_fecha1[0]."/".$array_fecha1[2]);
        $segundos2 = strtotime($array_fecha2[1]."/".$array_fecha2[0]."/".$array_fecha2[2]);
        $diferenciaSegundos = abs($segundos1 - $segundos2);
        $diferenciaDias = floor($diferenciaSegundos / (3600 * 24));
        ?>
        <div class="verde">
        <h1>Fechas - Respuesta</h1>
        <?php
        print "<p>La diferencia en días entre las dos fechas es de $diferenciaDias días.</p>";
        ?>
        </div>
        <?php
    }
    ?>
</body>
</html>