<?php
function tipoFichero($nombre) {
    $array_nombre = explode(".", $nombre);
    $ext = end($array_nombre);
    return $ext == "txt";
}

if (isset($_POST["btnEnviar"])){
    
    $error_form = $_FILES["fic"]["name"] == "" || !tipoFichero($_FILES["fic"]["name"]) || $_FILES["fic"]["size"] > 2.5 * 1024 * 1024;
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4 - Ficheros</title>
    <style>
        .error {color:red}
    </style>
</head>
<body>
    <h1>Ejercicio 4 - Ficheros</h1>
    <form action="ejercicio4.php" method="post" enctype="multipart/form-data">
        <p>
        <label for="fic">Introduce un fichero de texto (.txt) (Máx 2.5MB): </label>
        <input type="file" name="fic" id="fic" accept="text/*"> 
        <?php
        if (isset($_POST["btnEnviar"]) && $error_form){
            if ($_FILES["fic"]["name"] == ""){
                print "<span class='error'>No has introducido un archivo</span>";
            } else if (!tipoFichero($_FILES["fic"]["name"])) {
                print "<span class='error'>El tipo del archivo no es .txt</span>";
            } else {
                print "<span class='error'>El archivo pesa más de 2.5 MB</span>";
            }
        }
        ?>
        </p>
        <button type="submit" name="btnEnviar">Enviar</button>
    </form>
    <?php
    if (isset($_POST["btnEnviar"]) && !$error_form){
        
    }
    ?>
</body>
</html>