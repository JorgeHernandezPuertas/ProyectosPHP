<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
    <style>
    #cajaForm {background-color: lightblue;border: 3px solid black;margin-bottom: 10px;padding:10px} 
    #cajaRes {background-color: lightgreen;border: 3px solid black;padding:10px} 
    h2 {text-align: center;}
    </style>
</head>
<body>
    <?php
        $enviado = isset($_POST["btnEnviar"]);
        if ($enviado){
        $str1 = strtolower(trim($_POST["p1"]));
        $str2 = strtolower(trim($_POST["p2"]));
        $errorPalabra1 = $str1 == "";
        $errorPalabra2 = $str2 == "";
        $palabra1Corta = strlen($str1) < 3;
        $palabra2Corta = strlen($str2) < 3;
        $filtroPasado =  !($errorPalabra1 && $errorPalabra2 && $palabra1Corta && $palabra2Corta);
        }
    ?>


    <div id="cajaForm">
    <h2>Ripios - Formulario</h2>
    <form action="Ej1.php" method="post" enctype="multipart/form-data">
    <p>Dime dos palabras y te diré si riman o no.</p>
    <p>
        <label for="p1">Primera palabra: </label> <input type="text" name="p1" id="p1" value="<?php if ($enviado){echo $_POST["p1"];} ?>" />
        <?php
            if ($enviado && $errorPalabra1){
                echo "<span>* Campo vacío *</span>";
            } else if ($enviado && $palabra1Corta) {
                echo "<span>* La palabra tiene que tener más de 2 caracteres *</span>";
            }
        ?>
    </p>
    <p>
        <label for="p2">Segunda palabra: </label> <input type="text" name="p2" id="p2" value="<?php if ($enviado){echo $_POST["p2"];} ?>" />
        <?php
            if ($enviado && $errorPalabra2){
                echo "<span>* Campo vacío *</span>";
            } else if ($enviado && $palabra2Corta) {
                echo "<span>* La palabra tiene que tener más de 2 caracteres *</span>";
            }
        ?>
    </p>
    
    <p><input type="submit" value="Comparar" name="btnEnviar" /></p>
    </form>
    </div>
    
    
    <?php
        if ($enviado && $filtroPasado){
            ?>
            <div id="cajaRes">
            <h2>Ripios - Resultado</h2>
            <?php
                if ($_POST["p1"] == "" || $_POST["p2"] == ""){
                    echo "<p>No has puesto dos palabras.</p>";
                } else if (substr($str1, -3) == substr($str2, -3)){
                    echo "<p>".$_POST["p1"]." y ".$_POST["p2"]." riman.</p>";
                } else if (substr($str1, -2) == substr($str2, -2)){
                    echo "<p>".$_POST["p1"]." y ".$_POST["p2"]." riman un poquito.</p>";
                } else {
                    echo "<p>".$_POST["p1"]." y ".$_POST["p2"]." no riman.</p>";
                }
            ?>
            </div>
            <?php
        } 
    ?>
    

</body>
</html>