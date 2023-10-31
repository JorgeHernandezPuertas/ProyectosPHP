<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 7</title>
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
        $envTratado = trim($_POST["p1"]);
        $errorVacio = $envTratado == "";
        // Hago una regex para validar el formato de entrada
        $errorFormato = !preg_match("/^(-?\d+[.,]?\d*){1}( -?\d+[.,]?\d*)*$/", $envTratado);

        // Veo si no tiene ningún error
        $noErrores = !($errorVacio || $errorFormato);
    }
    ?>



    <div id="cajaForm">
    <h2>Unifica separador decimal - Formulario</h2>
    <form action="Ej7.php" method="post" enctype="multipart/form-data">
    <p>Escribe varios números separados por espacios y unificaré el separador decimal a puntos.</p>
    <p>
        <label for="p1">Números: </label> <textarea name="p1" id="p1"><?php if ($enviado) echo $_POST["p1"] ?></textarea>
        <?php
            if ($enviado && $errorVacio){
                echo "<span>* Campo Obligatorio *</span>";
            } else if ($enviado && $errorFormato){
                echo "<span>* No has escrito bien los números separados *</span>";
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
            <h2>Unifica separador decimal - Resultado</h2>
            <?php
                $sinComas = str_replace(",", ".", $envTratado);

                // Enseño el div que corresponda en función de lo que sea
                echo "<p>Números originales<ul>$envTratado</ul>  Números corregidos <ul>$sinComas</ul></p>";
            ?>
            </div>
            <?php
        } 
    ?>
    

</body>
</html>