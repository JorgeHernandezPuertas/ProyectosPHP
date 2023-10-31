<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria 1 - Ficheros de texto</title>
</head>

<body>
    <header>
        <h1>Teoría 1 - Ficheros de texto</h1>
    </header>

    <main>
        <?php
        // fopen() te devuelve un "puntero" en un punto especifico del fichero, por lo que hay que guardarlo en una variable para poder ir moviendolo sin perder el recorrido
        @$fd1 = fopen("prueba.txt", "r");
        @$fd2 = fopen("prueba.txt", "a");
        if (!$fd1){
            die("<p>No se ha podido abrir el fichero.txt</p>"); // Es como hacer un exit
        }

        echo "<p>Ahora todo en orden</p>";

        // El fgets() coge la línea que toque y pasa a la siguiente.
        $linea = fgets($fd1);
        echo "<p>$linea</p>";
        $linea = fgets($fd1);
        echo "<p>$linea</p>";
        $linea = fgets($fd1);
        echo "<p>$linea</p>";
        $linea = fgets($fd1);
        echo "<p>$linea</p>";

        fseek($fd1, 0); // El fseek es para situarte en el byte que quieras con el número (empieza en el 0)

        // Para recorrer un fichero se usa while porque fgets() cuando no quedan lineas devuelve false
        echo "<h3>recorro el fichero con un bucle while</h3>";
        while ($linea = fgets($fd1)){
            echo "<p>$linea</p>";
        }

        // Para escribir fwrite() o fputs()
        // Para saltar de linea hay que usar "\n" o la constante de PHP "PHP_EOL"
        // fwrite($fd2, "\n Esta linea la he escrito con php"); // Esta linea la comento para que no me escriba lineas cada vez que entro

        // función para leer un fichero entero, que devuelve un string
        $archivo_entero = file_get_contents("prueba.txt");
        print "<pre>$archivo_entero</pre>";

        // nl2br() es una función que te transforma los saltos de linea en <br/>

        // fclose() cierra el stream del fichero
        fclose($fd1);

        ?>
    </main>
</body>

</html>