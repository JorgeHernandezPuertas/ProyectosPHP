<?php
if (isset($_POST["btnEnviar"])) {
    
    // Como lo he hecho con date el único error es que esté el campo sin rellenar
    
    $error_fecha1_vacia = $_POST["fecha1"] == "";
    $error_fecha2_vacia = $_POST["fecha2"] == "";
    $errores = $error_fecha1_vacia || $error_fecha2_vacia;

    if (!$error_fecha1_vacia){
        $array_fecha1 = explode("-", $_POST["fecha1"]);
        $segundos1 = strtotime($array_fecha1[1]."/".$array_fecha1[2]."/".$array_fecha1[0]);
        $fecha1 = date("m/d/Y", $segundos1);
    }
    
    if (!$error_fecha2_vacia){
        $array_fecha2 = explode("-", $_POST["fecha2"]);
        $segundos2 = strtotime($array_fecha2[1]."/".$array_fecha2[2]."/".$array_fecha2[0]);
        $fecha2 = date("m/d/Y", $segundos2);
    }

}
?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fecha3</title>
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
        <form action="fecha3.php" method="post">
        <p>
            <label for="fecha1">Introduzca una fecha: </label>
            <input type="date" name="fecha1" value="<?php if (isset($_POST["btnEnviar"])) print $_POST["fecha1"] ?>" />
            <?php
            if (isset($_POST["btnEnviar"]) && $error_fecha1_vacia){
                print "<span class='error'> *Campo obligatorio* </span>";
            }
            ?>
        </p>
        <p>
        <label for="fecha2">Introduzca una fecha: </label>
            <input type="date" name="fecha2" value="<?php if (isset($_POST["btnEnviar"])) print $_POST["fecha2"] ?>" />
            <?php
            if (isset($_POST["btnEnviar"]) && $error_fecha2_vacia){
                print "<span class='error'> *Campo obligatorio* </span>";
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