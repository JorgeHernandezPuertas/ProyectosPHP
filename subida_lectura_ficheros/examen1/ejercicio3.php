<?php
require "funciones.php";


if (isset($_POST["btnEnviar"])){
    $error_form = $_POST["texto"] == "" || $_POST["des"] == "" 
    || !is_numeric($_POST["des"]) || $_POST["des"] < 1 || $_POST["des"] > 26 
    || $_FILES["archivo"]["error"] || $_FILES["archivo"]["size"] > 1.25 * 1024 * 1024 
    || $_FILES["archivo"]["type"] != "text/plain";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3 PHP</title>
    <style>
        .error {
            color:red
        }
    </style>
</head>
<body>
    <h2>Ejercicio 3. Codifica una frase</h2>
    <form action="ejercicio3.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="texto">Introduzca un Texto: </label>
            <input type="text" name="texto" id="texto" value="<?php if (isset($_POST["texto"])) print $_POST["texto"] ?>">
            <?php
                if (isset($_POST["btnEnviar"]) && $_POST["texto"] == ""){
                    print "<span class='error'> * Campo obligatorio * </span>";
                }
            ?>
        </p>
        <p>
            <label for="des">Desplazamiento: </label>
            <input type="text" name="des" id="des" value="<?php if (isset($_POST["des"])) print $_POST["des"] ?>">
            <?php
                if (isset($_POST["btnEnviar"])){
                    if ($_POST["texto"] == ""){
                        print "<span class='error'> * Campo obligatorio * </span>";
                    } else if (!is_numeric($_POST["des"])){
                        print "<span class='error'> * No has introducido un número * </span>";
                    } else if ($_POST["des"] < 1 || $_POST["des"] > 26){
                        print "<span class='error'> * El número tiene que estar entre 1 y 26 * </span>";
                    }
                }
            ?>
        </p>
        <p>
            <label for="archivo">Seleccione el archivo de claves (.txt y menor de 1,25MB) </label>
            <input type="file" name="archivo" id="archivo" accept=".txt">
            <?php
                if (isset($_POST["btnEnviar"])){
                    if ($_FILES["archivo"]["error"]){
                        print "<span class='error'> * Ha habido un error al subir el archivo * </span>";
                    } else if ($_FILES["archivo"]["size"] > 1.25 * 1024 * 1024){
                        print "<span class='error'> * El archivo supera los 1,25MB * </span>";
                    } else if ($_FILES["archivo"]["type"] != "text/plain"){
                        print "<span class='error'> * El archivo subido no es .txt * </span>";
                    }
                }
            ?>
        </p>
        <p>
            <button name="btnEnviar" type="submit">Codificar</button>
        </p>
    </form>
    <?php
        if (isset($_POST["btnEnviar"]) && !$error_form){
            print "<h2>Respuesta</h2>";

            @$fd = fopen($_FILES["archivo"]["tmp_name"], "r");
            if (!$fd){
                die ("<h4>Ha habido un error leyendo el archivo subido</h4>");
            }

            
            // Me salto la primera línea que me estorba
            fgets($fd);
            while($linea = fgets($fd)){
                $elementos_linea = mi_explode(";", $linea);
                $lineas_fichero[] = $elementos_linea;
            }
            fclose($fd);

            
            $entrada = $_POST["texto"];
            $texto_codificado = "";

            for ($i=0; $i < strlen($entrada); $i++) { 
                if (esta_matriz($entrada[$i], $lineas_fichero) != -1){
                    $num_fila = esta_matriz($entrada[$i], $lineas_fichero);
                    $texto_codificado .= $lineas_fichero[$num_fila + 1][$_POST["des"]];
                } else {
                    $texto_codificado .= $entrada[$i];
                }
            }
            
            print "<p>El texto introducido codificado sería: </p>";
            print "<p>$texto_codificado</p>";
        }
    ?>
</body>
</html>