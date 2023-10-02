<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
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
        $errorCorto = strlen($envTratado) > 2;
        $noErrores = !($errorNada || $errorCorto);
    }
        
    ?>



    <div id="cajaForm">
    <h2>Palíndromos / capícuas - Formulario</h2>
    <form action="Ej2.php" method="post" enctype="multipart/form-data">
    <p>Dime una palabra o un número y te diré si es un palíndromo o un número capicúa.</p>
    <p>
        <label for="p1">Palabra o número: </label> <input type="text" name="p1" id="p1" value="<?php if ($enviado) echo $_POST["p1"] ?>" />
        <?php
            if ($enviado && $errorNada){
                echo "<span>* Campo Obligatorio *</span>";
            } else if ($enviado && $errorCorto){
                echo "<span>* Tiene que tener mínimo 2 caracteres *</span>";
            }
        ?>
    </p>
    
    <p><input type="submit" value="Comprobar" name="btnEnviar" /></p>
    </form>
    </div>
    
    
    <?php
        if ($enviado && !$noErrores){
            ?>
            <div id="cajaRes1">
            <h2>Palíndromos / capícuas - Resultado</h2>
            <?php
                // Miro si es palindromo
                $esPalindromo = true;
                for ($i=0; $i < intdiv(strlen($envTratado), 2); $i++) { 
                    if ($envTratado[$i] != $envTratado[strlen($envTratado) - ($i + 1)]){
                        $esPalindromo = false;
                        break;
                    }
                }

                // Enseño el div que corresponda en función de lo que sea
                if ($esPalindromo){
                    if (is_numeric($envTratado)){
                        echo "<p>".$_POST["p1"]." es capícua.</p>";
                    } else {
                        echo "<p>".$_POST["p1"]." es un palíndromo.</p>";
                    }
                } else {
                    if (is_numeric($envTratado)){
                        echo "<p>".$_POST["p1"]." no es capícua.</p>";
                    } else {
                        echo "<p>".$_POST["p1"]." no es un palíndromo.</p>";
                    }
                }
            ?>
            </div>
            <?php
        } 
    ?>
    

</body>
</html>