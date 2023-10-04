<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría subir ficheros al servidor</title>
    <style>
        .error {color:Red}
    </style>
</head>
<body>
    





    <h2>Teoría subir fichero al servidor</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="archivo">Seleccione un archivo imagen (Máx 500KB): </label>
            <input type="file" name="archivo" id="archivo" accept="image/*" />
            <?php 
            if (isset($_POST["btnEnviar"]) && $error_fichero){
                if ($error_fichero_vacio){
                    echo "<span class='error'>No se ha enviado el archivo</span>";
                } else if (isset($_POST["btnEnviar"]) && $error_fichero_tipo){
                    echo "<span class='error'>Tipo del archivo no válido</span>";
                } else {
                    echo "<span class='error'>Tamaño del archivo excede 500KB</span>";
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnEnviar">Enviar</button>
        </p>
    </form>
</body>
</html>