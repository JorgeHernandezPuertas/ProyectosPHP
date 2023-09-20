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
        /* Arrays:
        $a = [3, 6, -1, 8];
        for ($i=0; $i < count($a); $i++) { 
            echo "<p>Número: ".$a[$i]."</p>";
        }
        */
        /* 
        Recogida de datos:
        Cuando se pasan los datos viene en una matriz llamada o $_POST o $_GET
        */
        if (isset($_POST["btnEnviar"])) {
            echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
            echo "<p><strong>Apellido: </strong>".$_POST["apellidos"]."</p>";
            echo "<p><strong>Clave: </strong>".$_POST["contra"]."</p>";
            echo "<p><strong>DNI: </strong>".$_POST["dni"]."</p>";
            if (!isset($_POST["sexo"])) {
                echo "<p><strong>Sexo: </strong>No seleccionado</p>";
            } else {
                echo "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
            }
            echo "<p><strong>Nacido en: </strong>".$_POST["nacido"]."</p>";
            echo "<p><strong>Comentarios: </strong>".$_POST["comentarios"]."</p>";
            if (isset($_POST["subscripcion"])) {
                echo "<p><strong>Subscripcion: </strong> Si</p>";
            } else {
                echo "<p><strong>Subscripcion: </strong> No</p>";
            }
        } else {
            header("Location: index.php");
        }
    ?>
</body>
</html>