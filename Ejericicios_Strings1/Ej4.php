<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
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
        $envTratado = strtoupper(trim($_POST["p1"]));
        $errorVacio = $envTratado == "";
        // Compruebo que cumplan la regex para ver si es un número romano válido
        $errorNoRomano = !preg_match("/^M{0,4}D{0,4}C{0,4}L{0,4}X{0,4}V{0,4}I{0,4}$/", $envTratado);

        // Calculo el valor del número romano
        $valorArabe = 0;
        for ($i=0; $i < strlen($envTratado); $i++) { 
            switch ($envTratado[$i]) {
                case 'M':
                    $valorArabe += 1000;
                    break;
                case 'D':
                    $valorArabe += 500;
                    break;
                case 'C':
                    $valorArabe += 100;
                    break;
                case 'L':
                    $valorArabe += 50;
                    break;
                case 'X':
                    $valorArabe += 10;
                    break;
                case 'V':
                    $valorArabe += 5;
                    break;
                default:
                    $valorArabe += 1;
                    break;
            }
        }
        // Compruebo que el número no sea mayor que 5000
        $mayorQue5000 = $valorArabe > 5000;

        // Veo si no tiene ningún error
        $noErrores = !($errorVacio || $errorNoRomano || $mayorQue5000);
    }
    ?>



    <div id="cajaForm">
    <h2>Romanos a árabes - Formulario</h2>
    <form action="Ej4.php" method="post" enctype="multipart/form-data">
    <p>Dime un número en números romanos antiguos y lo convertiré a cifras árabes.</p>
    <p>
        <label for="p1">Número: </label> <input type="text" name="p1" id="p1" value="<?php if ($enviado) echo $_POST["p1"] ?>" />
        <?php
            if ($enviado && $errorVacio){
                echo "<span>* Campo Obligatorio *</span>";
            } else if ($enviado && $errorNoRomano){
                echo "<span>* No has introducido un número romano válido *</span>";
            } else if ($enviado && $mayorQue5000){
                echo "<span>* El número romano es mayor que 5000 *</span>";
            }
        ?>
    </p>
    
    <p><input type="submit" value="Convertir" name="btnEnviar" /></p>
    </form>
    </div>
    
    
    <?php
        if ($enviado && $noErrores){
            ?>
            <div id="cajaRes1">
            <h2>Romanos a árabes - Resultado</h2>
            <?php
                // Enseño el div que corresponda en función de lo que sea
                echo "<p>El número romano ".$envTratado." se escribe en cifras árabes ".$valorArabe."</p>";
            ?>
            </div>
            <?php
        } 
    ?>
    

</body>
</html>