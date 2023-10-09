<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
    <style>
    #cajaForm {background-color: lightblue;border: 1px solid black;margin-bottom: 10px;padding:10px} 
    #cajaRes1 {background-color: lightgreen;border: 1px solid black;padding:10px} 
    h2 {text-align: center;}
    </style>
</head>
<body>
    <?php
    $enviado = isset($_POST["btnEnviar"]);
    if ($enviado){
        $envTratado = strtolower(trim($_POST["p1"]));
        $errorNada = $envTratado == "";
        $errorLongitud = strlen($envTratado) < 6;
        $noErrores = !($errorNada || $errorLongitud);
    }
        
    ?>



    <div id="cajaForm">
    <h2>Frases palíndromas - Formulario</h2>
    <form action="Ej3.php" method="post" enctype="multipart/form-data">
    <p>Dime una frase y te diré si es una frase palíndroma.</p>
    <p>
        <label for="p1">Frase: </label> <input type="text" name="p1" id="p1" value="<?php if ($enviado) echo $_POST["p1"] ?>" />
        <?php
            if ($enviado && $errorNada){
                echo "<span>* Campo Obligatorio *</span>";
            } else if ($enviado && $errorLongitud){
                echo "<span>* La frase tiene que tener una longitud mayor que 6 *</span>";
            }
        ?>
    </p>
    
    <p><input type="submit" value="Comprobar" name="btnEnviar" /></p>
    </form>
    </div>
    
    
    <?php
        function mi_stringReplace($str){
            $palabrasArr = explode(" ", $str);
            $palabrasJuntas = implode("", $palabrasArr);
            return $palabrasJuntas;
        }
        if ($enviado && $noErrores){
            ?>
            <div id="cajaRes1">
            <h2>Frases palíndromas - Resultado</h2>
            <?php
                // Exploto la frase para mirar solo las palabras
                $palabrasJuntas = mi_stringReplace($envTratado);

                // Miro si es palindromo
                $esPalindromo = true;
                for ($i=0; $i < intdiv(strlen($palabrasJuntas), 2); $i++) { 
                    if ($palabrasJuntas[$i] != $palabrasJuntas[strlen($palabrasJuntas) - ($i + 1)]){
                        $esPalindromo = false;
                        break;
                    }
                }

                // Enseño el div que corresponda en función de lo que sea
                if ($esPalindromo){
                    echo "<p>".$_POST["p1"]." es una frase palíndroma.</p>";
                } else {
                    echo "<p>".$_POST["p1"]." no es una frase palíndroma.</p>";
                }
            ?>
            </div>
            <?php
        } 
    ?>
    

</body>
</html>