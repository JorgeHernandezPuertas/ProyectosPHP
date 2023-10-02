<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
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
        $errorVacio = $envTratado == "";

        // Veo si no tiene ningún error
        $noErrores = !($errorVacio);
    }
    ?>



    <div id="cajaForm">
    <h2>Quitar acentos - Formulario</h2>
    <form action="Ej6.php" method="post" enctype="multipart/form-data">
    <p>Escribe un texto y le quitaré los acentos.</p>
    <p>
        <label for="p1">Texto: </label> <textarea name="p1" id="p1"><?php if ($enviado) echo $_POST["p1"] ?></textarea>
        <?php
            if ($enviado && $errorVacio){
                echo "<span>* Campo Obligatorio *</span>";
            }
        ?>
    </p>
    
    <p><input type="submit" value="Quitar acentos" name="btnEnviar" /></p>
    </form>
    </div>
    
    
    <?php
        if ($enviado && $noErrores){
            ?>
            <div id="cajaRes1">
            <h2>Quitar acentos - Resultado</h2>
            <?php
                function quitarAcentos($str){
                    $vocalesAcento = array("á", "é", "í", "ó", "ú", "ü",
                                           "Á", "É", "Í", "Ó", "Ú", "Ü");
                    $vocalesSinAcento = array("a", "e", "i", "o", "u", "u", 
                                              "A", "E", "I", "O", "U", "U");

                    $sinAcentos = str_replace($vocalesAcento, $vocalesSinAcento, $str);
                    $sinAcentos = strtolower($sinAcentos);
                    return $sinAcentos;
                }

                // Quito todos los acentos
                $sinAcentos = quitarAcentos($envTratado);
                
                // Pongo la primera mayúscula
                $envTratado[0] = strtoupper($envTratado[0]);
                $sinAcentos[0] = strtoupper($sinAcentos[0]);

                // Enseño el div que corresponda en función de lo que sea
                echo "<p>Texto original<ul>$envTratado</ul>  Texto sin acentos <ul>$sinAcentos</ul></p>";
            ?>
            </div>
            <?php
        } 
    ?>
    

</body>
</html>