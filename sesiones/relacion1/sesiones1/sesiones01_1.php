<?php
session_name("sesiones01_1");
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Nombre 1 (Formulario)</title>
</head>

<body>
    <h1>FORMULARIO NOMBRE 1 (FORMULARIO)</h1>
    <?php
    if (isset($_SESSION["nombre"])){
        print "<p>Su nombre es: <strong>".$_SESSION["nombre"]."</strong></p>";
    }
    ?>
    <p>Escriba su nombre:</p>
    <form action="sesiones01_2.php" method="post">
        <p><label for="nombre"><strong>Nombre:</strong></label><input type="text" name="nombre" id="nombre"></p>
        <p><button name="btnEnviar">Siguiente</button> <button name="btnBorrar">Borrar</button></p>
    </form>
</body>

</html>