<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica examen 1 - Ejercicio 1</title>
    <style>
        .error {
            color: red
        }
    </style>
</head>

<body>
    <h1>Contar caracteres</h1>
    <form action="ejercicio1.php" method="post">
        <p>
            <label for="palabra">Introduce caracteres: </label>
            <input type="text" name="palabra" id="palabra" value="<?php if (isset($_POST["palabra"])) print $_POST["palabra"]; ?>">
        </p>
        <button type="submit" name="btnEnviar">Contar</button>
    </form>

    <?php
    if (isset($_POST["btnEnviar"]))  {
        $contador = 0;
        while(isset($_POST["palabra"][$contador])){
            $contador++;
        }
        print "<p>En la cadena de caracteres introducida hay $contador caracteres.</p>";
    }
    ?>

</body>

</html>