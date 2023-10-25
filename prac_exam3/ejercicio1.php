<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
    <style>
        textarea {
            width: 8em;
            height: 8em;
        }
    </style>
</head>

<body>
    <h2>Ejercicio 1. Generador de "claves_polybios.txt"</h2>
    <form action="ejercicio1.php" method="post">
        <input type="submit" name="btnEnviar" value="Generar">
    </form>
    <?php
    if (isset($_POST["btnEnviar"])) {
        @$fd = fopen("claves_polybios.txt", "w");
        if (!$fd) {
            print "<p>No se ha podido generar el fichero</p>";
        }

        print "<h3>Respuesta</h3>";
        print "<textarea>";
        $n_col = 6;
        for ($i = 0; $i < $n_col; $i++) {
            if ($i == 0) {
                fwrite($fd, "i/j");
                print "i/j";
            } else {
                fwrite($fd, ";$i");
                print ";$i";
            }
        }

        /*
        $letras = array(
            array("A", "B", "C", "D", "E"),
            array("F", "G", "H", "I", "K"),
            array("L", "M", "N", "O", "P"),
            array("Q", "R", "S", "T", "U"),
            array("V", "W", "X", "Y", "Z")
        );
*/
        $fila = 1;
            for ($i=ord("A"); $i < ord("Z") ; $i++) { 
                if (($i - ord("A")) % 5 == 0){
                    fwrite($fd, "\n$fila;".chr($i));
                    print "\n$fila;".chr($i);
                    $fila++;
                } else if (ord("J") <= $i){ // La J no esta
                    fwrite($fd, ";".chr($i + 1));
                    print ";".chr($i + 1);
                } else { // Antes de la J
                    fwrite($fd, ";".chr($i));
                    print ";".chr($i);
                }
            }

/*/

        for ($i = 1; $i < 6; $i++) {
            for ($j = 0; $j < $n_col; $j++) {
                if ($j == 0) {
                    fwrite($fd, "$i");
                    print "$i";
                } else {
                    fwrite($fd, ";".$letras[$i - 1][$j - 1]);
                    print ";".$letras[$i - 1][$j - 1];
                }
            }
            fwrite($fd, "\n");
            print "\n";
        }
        */
        print "</textarea>";

        fclose($fd);
    }
    ?>
</body>

</html>