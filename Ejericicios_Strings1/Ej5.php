<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5</title>
    <style>
    #cajaForm {background-color: lightblue;border: 1px solid black;margin-bottom: 10px;padding:10px} 
    #cajaRes1 {background-color: lightgreen;border: 1px solid black;padding:10px} 
    h2 {text-align: center;}
    </style>
</head>
<body>
    <?php
    $enviado = isset($_POST["btnEnviar"]); // Compruebo errores
    if ($enviado){
        $envTratado = strtoupper(trim($_POST["p1"]));
        $errorVacio = $envTratado == "";
        // Compruebo si es un numero natural
        $errorNumero = !preg_match("/^\d*$/", $envTratado); // Miro si es un int
        $mayorQue5000 = $envTratado > 5000;

        // Veo si no tiene ningún error
        $noErrores = !($errorVacio || $errorNumero || $mayorQue5000);
    }
    ?>



    <div id="cajaForm">
    <h2>Árabes a romanos - Formulario</h2>
    <form action="Ej5.php" method="post" enctype="multipart/form-data">
    <p>Dime un número y lo convertiré a números romanos.</p>
    <p>
        <label for="p1">Número: </label> <input type="text" name="p1" id="p1" value="<?php if ($enviado) echo $_POST["p1"] ?>" />
        <?php
            if ($enviado && $errorVacio){
                echo "<span>* Campo Obligatorio *</span>";
            } else if ($enviado && $errorNumero){
                echo "<span>* No has introducido un número válido *</span>";
            } else if ($enviado && $mayorQue5000){
                echo "<span>* El número es mayor que 5000 *</span>";
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
            <h2>Árabes a romanos - Resultado</h2>
            <?php
            // Procedo el número normal a romano
            $romano = "";
            $revesNumero = strrev($envTratado);
            for ($i = 0; $i < strlen($revesNumero); $i++) { 
                switch ($i) {
                    case 0:
                        if ($revesNumero[$i] < 5){ // Si es menor de 5 relleno con la letra correspondiente
                            for ($j=0; $j < $revesNumero[$i]; $j++) { 
                                $romano .= "I";
                            }
                        } else { // Si es mayor pongo el siguiente y relleno lo que haga falta con la correspondiente
                            for ($j=0; $j < $revesNumero[$i] - 5; $j++) { 
                                $romano .= "I";
                            }
                            $romano .= "V";
                        }
                        break;
                    case 1:
                        if ($revesNumero[$i] < 5){ // Si es menor de 5 relleno con la letra correspondiente
                            for ($j=0; $j < $revesNumero[$i]; $j++) { 
                                $romano .= "X";
                            }
                        } else { // Si es mayor pongo el siguiente y relleno lo que haga falta con la correspondiente
                            for ($j=0; $j < $revesNumero[$i] - 5; $j++) { 
                                $romano .= "X";
                            }
                            $romano .= "L";
                        }
                        break;
                    case 2:
                        if ($revesNumero[$i] < 5){ // Si es menor de 5 relleno con la letra correspondiente
                            for ($j=0; $j < $revesNumero[$i]; $j++) { 
                                $romano .= "C";
                            }
                        } else { // Si es mayor pongo el siguiente y relleno lo que haga falta con la correspondiente
                            for ($j=0; $j < $revesNumero[$i] - 5; $j++) { 
                                $romano .= "C";
                            }
                            $romano .= "D";
                        }
                        break;
                    case 3:
                        if ($revesNumero[$i] < 5){ // Si es menor de 5 relleno con la letra correspondiente
                            for ($j=0; $j < $revesNumero[$i]; $j++) { 
                                $romano .= "M";
                            }
                        } else { // Si es mayor pongo el siguiente y relleno lo que haga falta con la correspondiente
                            $romano .= "DD";
                            for ($j=0; $j < 5; $j++) { 
                                $romano .= "M";
                            }
                        }
                    default:
                        break;
                }
            }
            // Lo pongo del derecho
            $romano = strrev($romano);


                // Enseño el div que corresponda en función de lo que sea
                echo "<p>El número ".$envTratado." se escribe en números romanos ".$romano."</p>";
            ?>
            </div>
            <?php
        } 
    ?>
    

</body>
</html>