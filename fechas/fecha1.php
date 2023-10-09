<?php
if (isset($_POST["btnEnviar"])) {
    // Compruebo la fecha1
    $fecha1 = trim($_POST["fecha1"]);
    $error_fecha1_vacia = $fecha1 == "";
    $error_fecha1_formato = preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $fecha1);
    $error_fecha1_posible = false;
    if (!$error_fecha1_formato) {
        $array_fecha1 = explode("/", $fecha1);
        $error_fecha1_posible = !checkdate($array_fecha1[1], $array_fecha1[0], $array_fecha1[2]);
    }
    $error_fecha1 = $error_fecha1_vacia || $error_fecha1_formato || $error_fecha1_posible;

    // Compruebo la fecha2
    $fecha2 = trim($_POST["fecha2"]);
    $error_fecha2_vacia = $fecha1 == "";
    $error_fecha2_formato = preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $fecha2);
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
</head>

<body>
    <h1>Fechas-Formulario</h1>
    <form action="fecha1.php" method="post"></form>
    <p>
        <label for="fecha1">Introduzca una fecha: (DD/MM/YYYY)</label>
        <input type="text" name="fecha1" id="fecha1" value="<?php if (isset($_POST["btnEnviar"]) && !$error_fecha1) echo $_POST["fecha1"] ?>" />
    </p>
    <p>
        <label for="fecha2">Introduzca una fecha: (DD/MM/YYYY)</label>
        <input type="text" name="fecha2" id="fecha2" value="<?php if (isset($_POST["btnEnviar"]) && !$error_fecha1) echo $_POST["fecha2"] ?>" />
    </p>
    <p>
        <input type="submit" name="btnEnviar" value="Calcular" />
    </p>

</body>

</html>