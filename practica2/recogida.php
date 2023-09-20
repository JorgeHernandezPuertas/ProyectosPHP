
<?php
    if(isset($_POST["btnEnviar"])){
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Recogida - Práctica 2</title>
    </head>
    <body>
        <h2>Recogiendo datos</h2>
        <?php
            echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
            echo "<p><strong>Nacido en: </strong>".$_POST["nacido"]."</p>";
            if (isset($_POST["sexo"])){
                echo "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
            } else {
                echo "<p><trong>Sexo: </strong>No ha marcado el sexo</p>";
            }
            if (isset($_POST["aficiones"])){
                $afi = "";
                foreach ($_POST["aficiones"] as $value) {
                    $afi = $afi.", ".$value;
                }
                echo "<p><strong>Aficiones: </strong>".$afi."</p>";
            } else {
                echo "<p><trong>Aficiones: </strong>No tiene ninguna afición</p>";
            }
            echo "<p><strong>Comentarios: </strong>".$_POST["comentarios"]."</p>";;
        ?>
    </body>
    </html>
<?php
    } else {
    header("Location: index.php");
    }
?>

