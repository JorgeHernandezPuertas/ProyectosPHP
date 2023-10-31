<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rellan tu CV</title>
</head>
<body>
    <h1>DATOS ENVIADOS</h1>
    <?php
    print "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
    print "<p><strong>Usuario: </strong>".$_POST["usuario"]."</p>";
    print "<p><strong>Contraseña: </strong>".$_POST["password"]."</p>";
    print "<p><strong>DNI: </strong>".$dni."</p>";
    print "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
    if (isset($_POST["sub"])){
        print "<p><strong>Subscripción: </strong>Aceptada</p>";
    } else {
        print "<p><strong>Subscripción: </strong>No aceptada</p>";
    }

    // Si mandan la imagen muestro su información
    if ($_FILES["imagen"]["name"] != ""){
        // Cojo la extensión del archivo
        $extension = "";
        $arrayPartes = explode(".", $_FILES["imagen"]["name"]);
        if (count($arrayPartes) >= 1){
            $extension = "." . end($arrayPartes);
        }
        $nombre_unico = md5(uniqid(uniqid(),true));
        $nombre_final = $nombre_unico . $extension;

        ?>
        <h3>Información de la imagen seleccionada</h3>
        <?php
        print "<strong>Error: </strong>".$_FILES["imagen"]["error"]." <br/>";
        print "<strong>Nombre: </strong>".$_FILES["imagen"]["name"]."<br/>";
        print "<strong>Ruta en Servidor: </strong>".$_FILES["imagen"]["tmp_name"]."<br/>";
        print "<strong>Tipo archivo: </strong>".$_FILES["imagen"]["type"]."<br/>";
        print "<strong>Tamaño archivo: </strong>".$_FILES["imagen"]["size"]." bytes<br/>";
        // Subo la imagen
        @$var = move_uploaded_file($_FILES["imagen"]["tmp_name"], "images/$nombre_final");
        if ($var){
            print "<p>La imagen ha sido subida con éxito</p>";
        } else {
            print "La imagen no ha podido guardarse en el servidor con éxito";
        }
        ?>
        
        <?php
    }
    
    ?>
</body>
</html>