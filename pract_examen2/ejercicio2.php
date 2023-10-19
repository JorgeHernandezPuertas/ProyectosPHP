<?php

if (isset($_POST["btnEnviar"])){
    $error_form = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["type"] != "text/plain" || $_FILES["archivo"]["error"];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica examen 1 - Ejercicio 2</title>
</head>
<body>
    <h1>Subir fichero txt</h1>
    <form action="ejercicio2.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="fichero">Sube un fichero txt (Máx. 1MB): </label>
            <input type="file" name="fichero" id="fichero" accept=".txt" >
            <?php
            if (isset($_POST["btnEnviar"]) && $error_form){
                
            }
            ?>
        </p>
        <button type="submit" name="btnEnviar">Enviar</button>
    </form>


</body>
</html>