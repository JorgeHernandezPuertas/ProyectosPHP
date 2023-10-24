<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>
<body>
    <h2>Ejercicio 1. Generador de "claves_polybios.txt"</h2>
    <form action="ejercicio1.php" method="post">
        <input type="submit" name="btnEnviar" value="Generar">
    </form>
    <?php
        if (isset($_POST["btnEnviar"])){
            @$fd = fopen("claves_polybios.txt", "w");
            if (!$fd){
                print "<p>No se ha podido generar el fichero</p>";
            }

            print "<h3>Respuesta</h3>";
            print "<textarea>";
            $n_col = 6;
            for ($i=0; $i < $n_col; $i++) { 
                if ($i == 0){
                    fwrite($fd, "i/j");
                    print "i/j";
                } else {
                    fwrite($fd, "$i");
                    print ";$i";
                }
            }
            fwrite($fd, "\n");
            print "\n";

            $letras = array("A", "B", "C", "D", "E",
                            "F", "G", "H", "I","K",
                            "L", "M", "N", "O","P",
                            "Q", "R", "S", "T", "U",
                            "V", "W", "X", "Y", "Z");


            print "</textarea>";
            
            fclose($fd);
        }
    ?>
</body>
</html>