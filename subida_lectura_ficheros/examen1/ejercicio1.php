<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1 PHP</title>
    <style>
        textarea {
            width: 60em;
            height: 35em;
        }
    </style>
</head>

<body>
    <h2>Ejercicio 1. Generador de "claves_cesar.txt"</h2>
    <form action="ejercicio1.php" method="post">
        <button type="submit" name="btnEnviar">Generar</button>
    </form>

    <?php
    if (isset($_POST["btnEnviar"])){
        @$fd = fopen("claves_cesar.txt", "w");
        if (!$fd){
            die("<p>No se ha podido generar el fichero por permisos.</p>");
        }

        print "<p><textarea>";

        // Genero la cabecera
        for ($i=0; $i < 27; $i++) { 
            if ($i == 0){
                fwrite($fd, "Letra/Desplazamiento");
                print "Letra/Desplazamiento";
            } else {
                fwrite($fd, ";$i");
                print ";$i";
            }
        }
        // Salto de linea
        fwrite($fd, "\n");
        print "\n";

        // Genero el cuerpo del fichero
        for ($i=0; $i < 26; $i++) { 
            for ($j=ord("A"); $j <= ord("Z") + 1; $j++) { 
                if ($j == ord("A")){ // Esto if lo meto por el ;
                    $letra = chr($i + $j);
                } else {
                    $letra = ";".chr(($j + $i - ord("A")) % 26 + ord("A"));
                }
                fwrite($fd, "$letra");
                print "$letra";
            }
            // Salto de linea
            fwrite($fd, "\n");
            print "\n";
        }
        
        print "</textarea></p>";

        fclose($fd);

    }
    ?>

</body>

</html>