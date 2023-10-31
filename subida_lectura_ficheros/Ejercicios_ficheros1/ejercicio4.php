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
        <input type="file" name="fic" id="fic" accept=".txt"> 
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
        $array_nombre = explode(".", $_FILES["fic"]["name"]);
        $ext = end($array_nombre); // Cojo la extensión del archivo
        $nombre_nuevo = md5(uniqid(uniqid())).".$ext"; // Creo un nombre nuevo aleatorio

        // Muevo el fichero a la carpeta ficheros
        @$var = move_uploaded_file($_FILES["fic"]["tmp_name"], "ficheros/$nombre_nuevo");
        if (!$var){
            die("<p class='error'>No se ha podido guardar el fichero en el servidor</p>");
        }

        // Establezco la ruta del fichero
        $rutaFichero = "ficheros/$nombre_nuevo";

        @$fd = fopen($rutaFichero, "r");
        if (!$fd){
            die("<p>No se puede leer el archivo</p>");
        }

        $contador = 0;
        while($linea = fgets($fd)){
            $contador += str_word_count($linea);
        }

        print "<p>El fichero subido tiene $contador palabras escritas en él.</p>";

    }
    ?>
</body>
</html>