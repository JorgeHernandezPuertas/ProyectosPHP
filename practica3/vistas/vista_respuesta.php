<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1 - Recogida</title>
</head>
<body>
    <h2>Recogiendo los datos</h2>
    <?php
            echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
            echo "<p><strong>Apellido: </strong>".$_POST["apellidos"]."</p>";
            echo "<p><strong>Clave: </strong>".$_POST["contra"]."</p>";
            echo "<p><strong>DNI: </strong>".$_POST["dni"]."</p>";
            echo "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
            echo "<p><strong>Nacido en: </strong>".$_POST["nacido"]."</p>";
            echo "<p><strong>Comentarios: </strong>".$_POST["comentarios"]."</p>";
            if (isset($_POST["subscripcion"])) {
                echo "<p><strong>Subscripcion: </strong> Si</p>";
            } else {
                echo "<p><strong>Subscripcion: </strong> No</p>";
            }
    ?>
</body>
</html>