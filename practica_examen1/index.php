<?php
if (isset($_POST["btnEnviar"])) {
    $palabra = strtolower(trim($_POST["palabra"]));
    $error_form = $palabra == "" || strlen($palabra) < 2;
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica examen</title>
    <style>
        .error {color:red}
    </style>
</head>

<body>
    <!-- Formulario con un campo de texto, en el que tengas que teclar una palabra, y debajo tiene que poner si se ha repetido algún caracter o si no  -->
    <h2>Repetir caracteres</h2>
    <form action="index.php" method="post">
        <p>
            <label for="palabra">Introduce una palabra: </label>
            <input type="text" name="palabra" id="palabra" value="<?php if (isset($_POST["palabra"])) print $_POST["palabra"]; ?>"> 
            <?php
            if (isset($_POST["btnEnviar"]) && $error_form) {
                if ($palabra == ""){
                    print "<span class='error'> * Campo obligatorio * </span>";
                } else {
                    print "<span class='error'> * Los caracteres minimos son 2 * </span>";
                }
                
            }
            ?>
        </p>
        <button type="submit" name="btnEnviar">Comprobar</button>
    </form>

    <?php
    if (isset($_POST["btnEnviar"]) && !$error_form) {
        $repite = false;
        for($i = 1; $i < strlen($palabra); $i++){
            for($j = 0; $j < $i; $j++){
                if ($palabra[$i] == $palabra[$j]){
                    $repite = true;
                    break;
                }
            }
            if ($j < $i){ // Si se cumple esto es que me he salido del anterior for
                break;
            }
        }

        if ($repite){
            print "<p>La palabra '$palabra' repite caracteres.</p>";
        } else {
            print "<p>La palabra '$palabra' no repite caracteres.</p>";
        }
    }
    ?>
</body>

</html>