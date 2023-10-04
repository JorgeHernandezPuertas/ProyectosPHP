
<?php 
    if (isset($_POST["btnEnviar"])){
        $error_fichero_vacio = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"];
        $error_fichero_tipo = !getimagesize($_FILES["archivo"]["tmp_name"]);
        $error_fichero_tam = $_FILES["archivo"]["size"] > 500*1024; // El size de $_FILES viene en bytes
        $error_fichero = $error_fichero_vacio || $error_fichero_tipo || $error_fichero_tam;
    }


    if (isset($_POST["btnEnviar"]) && !$error_fichero_vacio){
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Enviado</title>
        </head>
        <body>
            <h2>¡Has enviado el archivo!</h2>
        </body>
        </html>
        <?php
    } else {
        require "vistas/vista_formulario.php";
    }
    ?>

