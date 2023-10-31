<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría subir fichero al servidor</title>
    <style>
        .tam_img {width:35%}
    </style>
</head>

<body>
    <h1>Teoría subir ficheros al servidor</h1>
    <h2>Datos del archivo subido</h2>
    <?php
    $nombre_nuevo = md5(uniqid(uniqid(), true));
    $array_nombre = explode(".", $_FILES["archivo"]["name"]);
    $extension = "";
    if (count($array_nombre) > 1){
        $extension = ".".end($array_nombre);
    }

    $nombre_nuevo .= $extension;
    @$var = move_uploaded_file($_FILES["archivo"]["tmp_name"], "img/$nombre_nuevo");
    if($var){
        echo "<h3>Foto</h3>";
        echo "<p><strong>Nombre: </strong>".$_FILES["archivo"]["name"]."</p>";
        echo "<p><strong>Tipo: </strong>".$_FILES["archivo"]["type"]."</p>";
        echo "<p><strong>Tamaño: </strong>".$_FILES["archivo"]["size"]."</p>";
        echo "<p><strong>Nombre temporal: </strong>".$_FILES["archivo"]["tmp_name"]."</p>";
        echo "<p><strong>Error: </strong>".$_FILES["archivo"]["error"]."</p>";
        echo "<p>La imagen ha sido subida con éxito</p>";
        echo "<p><img class='tam_img' src='img/$nombre_nuevo' alt='Foto' title='Foto' /></p>";

    } else {
        echo "<p>No se ha podido mover la imagen a la carpeta destino en el servidor.</p>";
    }

    
    ?>
</body>
</html>