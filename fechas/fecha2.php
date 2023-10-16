<?php
if (isset($_POST["btnEnviar"])) {
    
    // Como he hecho con options la introducción de fechas, el unico error que puede haber es que no exista esa fecha
    // porque el formato es siempre el mismo
    $error_fecha1_invalida = !checkdate($_POST["mes1"], $_POST["dia1"], $_POST["anio1"]);

    $error_fecha2_invalida = !checkdate($_POST["mes2"], $_POST["dia2"], $_POST["anio2"]);

    $errores = $error_fecha1_invalida || $error_fecha2_invalida;

}
?>




<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fecha2</title>
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
        <form action="fecha2.php" method="post">
        <p>
            <label for="dia1">Día: </label>
            <select name="dia1" id="dia1">
            <?php
                for ($i=1; $i < 32; $i++) { 
                    if (isset($_POST["btnEnviar"]) && $_POST["dia1"] == $i){
                        printf("<option value='%02d' selected >%02d</option>", $i, $i);
                    } else {
                        printf("<option value='%02d'>%02d</option>", $i, $i);
                    }
                }
                ?>
            </select> 
            <label for="mes1">Mes: </label>
            <select name="mes1" id="mes1">
                <?php
                $meses = Array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto",
                 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");
                foreach($meses as $i => $v){
                    if (isset($_POST["btnEnviar"]) && $_POST["mes1"] == $i){
                        printf("<option value='%02d' selected >%s</option>", $i, $v);
                    } else {
                        printf("<option value='%02d'>%s</option>", $i, $v);
                    }
                }
                ?>
            </select> 
            <label for="anio1">Año: </label>
            <select name="anio1" id="anio1">
                <?php
                // Hago 50 atras años desde este año
                $anioActual = date("Y");

                for ($i=$anioActual - 50; $i <= $anioActual; $i++) {
                    if (isset($_POST["btnEnviar"]) && $_POST["anio1"] == $i){
                        print "<option value='$i' selected >$i</option>";
                    } else {
                        print "<option value='$i'>$i</option>";
                    }
                }
                ?>
            </select>
            <?php
            if (isset($_POST["btnEnviar"]) && $error_fecha1_invalida){
                print "<span class='error'> *La fecha introducida no existe* </span>";
            }
            ?>
        </p>
        <p>
        <label for="dia2">Día: </label>
            <select name="dia2" id="dia2">
                <?php
                for ($i=1; $i < 32; $i++) { 
                    if (isset($_POST["btnEnviar"]) && $_POST["dia2"] == $i){
                        printf("<option value='%02d' selected >%02d</option>", $i, $i);
                    } else {
                        printf("<option value='%02d'>%02d</option>", $i, $i);
                    }
                }
                ?>
            </select> 
            <label for="mes2">Mes: </label>
            <select name="mes2" id="mes2">
            <?php
                foreach($meses as $i => $v){
                    if (isset($_POST["btnEnviar"]) && $_POST["mes2"] == $i){
                        printf("<option value='%02d' selected >%s</option>", $i, $v);
                    } else {
                        printf("<option value='%02d'>%s</option>", $i, $v);
                    }
                }
                ?>
            </select> 
            <label for="anio2">Año: </label>
            <select name="anio2" id="anio2">
                <?php
                for ($i=$anioActual - 50; $i <= $anioActual; $i++) { 
                    if (isset($_POST["btnEnviar"]) && $_POST["anio2"] == $i){
                        print "<option value='$i' selected >$i</option>";
                    } else {
                        print "<option value='$i'>$i</option>";
                    }
                }
                ?>
            </select>
            <?php
            if (isset($_POST["btnEnviar"]) && $error_fecha2_invalida){
                print "<span class='error'> *La fecha introducida no existe* </span>";
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
        
        $segundos1 = strtotime($_POST["mes1"]."/".$_POST["dia1"]."/".$_POST["anio1"]);
        $segundos2 = strtotime($_POST["mes2"]."/".$_POST["dia2"]."/".$_POST["anio2"]);
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