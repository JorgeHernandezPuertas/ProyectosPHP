<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1 - Recogida</title>
</head>
<body>
    <h2>Estos son los datos enviados:</h2>
    <?php
            echo "<p><strong>El nombre enviado ha sido: </strong>".$_POST["nombre"]."</p>";
            echo "<p><strong>Ha nacido en: </strong>".$_POST["nacido"]."</p>";
            echo "<p><strong>El sexo es: </strong>".$_POST["sexo"]."</p>";
            if (isset($_POST["aficiones"]) && count($_POST["aficiones"]) == 1){
                echo "<p><strong>La afición seleccionada ha sido:</strong></p>";
                echo "<ol>";
                echo "<li>".$_POST["aficiones"][0]."</li>";
                echo "</ol>";
            } else if (isset($_POST["aficiones"]) && count($_POST["aficiones"]) > 1) {
                echo "<p><strong>Las aficiones seleccionadas han sido:</strong></p>";
                echo "<ol>";
                foreach ($_POST["aficiones"] as $key) {
                    echo "<li>$key</li>";
                }
                echo "</ol>";
            } else {
                echo "<p><strong>No has seleccionado ninguna afición</strong></p>";
            }
            if ($_POST["comentarios"] != ""){
                echo "<p><strong>El comentario ha sido: </strong> ".$_POST["comentarios"]." </p>";
            } else {
                echo "<p><strong>No hecho ningún comentario</strong></p>";
            }
    ?>
</body>
</html>