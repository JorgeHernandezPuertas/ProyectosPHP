<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO - Ejercicio3</title>
</head>
<body>
    <h2>POO - Ejercicio3</h2>
    <?php
    require "class_fruta.php";
    // Creo unas cuantas frutas
    $listaFrutas = array();
    for ($i=0; $i < 5; $i++) { 
        $listaFrutas[] = new Fruta("rojo","3kg");
    }
    print "<h4>Creando 5 frutas...</h4>";
    
    // Llamo al método estático de la clase Fruta
    print "<p>Actualmente hay ".Fruta::cuantaFruta()." frutas creadas</p>";
    unset($listaFrutas[0]);
    print "<h4>Destruyendo 1 fruta...</h4>";
    print "<p>Después de borrar una fruta quedan ".Fruta::cuantaFruta()." frutas</p>";
    ?>
</body>
</html>