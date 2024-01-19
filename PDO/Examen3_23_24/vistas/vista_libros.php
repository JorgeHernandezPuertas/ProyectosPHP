<?php

// hacerlo con el require como una vista nueva ya que se hace en home y en vista normal


echo "<h3>Listado de los libros</h3>";
// consulta con la que cojo todos los libros
try {
    $resultado = mysqli_query($conexion, "select * from libros");
} catch (Exception $e) {
    session_destroy();
    mysqli_close($conexion);
    die("<p>No he podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
}

// muestro los libros con el bucle
while ($tupla = mysqli_fetch_assoc($resultado)) {
    echo "<div class='fotos'>";
    echo "<img src='img/" . $tupla["portada"] . "' alt='imagen libro' title='imagen libro'><br>";
    echo $tupla["titulo"] . " - " . $tupla["precio"] . "€";
    echo "</div>";
}

// libero el resultado
mysqli_free_result($resultado);
