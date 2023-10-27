<?php
require "funciones.php";

if (isset($_POST["btnEnviar"])){
    $error_form = $_POST["texto"] == "";
}

?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2 PHP</title>
    <style>
        .error {
            color:red
        }
    </style>
</head>

<body>
    <h2>Ejercicio 2. Contar Palabras sin las vocales (a, e, i , o, u, A, E, I, O, U)</h2>
    <form action="ejercicio2.php" method="post">
        <p>
            <label for="texto">Introduzca un Texto: </label>
            <input type="text" name="texto" id="texto" value="<?php if (isset($_POST["texto"])) print $_POST["texto"] ?>">
            <?php
                if (isset($_POST["btnEnviar"]) && $error_form){
                    print "<span class='error'> * Campo obligatorio * </span>";
                }
            ?>
        </p>
        <p>
            <label for="separador">Elija el Separador: </label>
            <select name="separador" id="separador">
                <option value=";" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ";") print "selected" ?>>Punto y coma</option>
                <option value=":" <?php if (isset($_POST["separador"]) && $_POST["separador"] == ":") print "selected" ?>>Dos puntos</option>
                <option value="." <?php if (isset($_POST["separador"]) && $_POST["separador"] == ".") print "selected" ?>>Punto</option>
                <option value="," <?php if (isset($_POST["separador"]) && $_POST["separador"] == ",") print "selected" ?>>Coma</option>
                <option value="/" <?php if (isset($_POST["separador"]) && $_POST["separador"] == "/") print "selected" ?>>Barra ascendente</option>
            </select>
        </p>
        <p>
            <button name="btnEnviar" type="submit">Contar</button>
        </p>
    </form>
    <?php
        if (isset($_POST["btnEnviar"]) && !$error_form){
            print "<h2>Respuesta</h2>";

            $palabras = mi_explode_sin_vocales($_POST["separador"], $_POST["texto"]);

            print "El texto ".$_POST["texto"]." con el separador ".$_POST["separador"]." contiene ". count($palabras) . " palabras sin vocales";


        }
    ?>
</body>

</html>