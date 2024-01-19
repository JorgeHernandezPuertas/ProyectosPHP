<?php

// hacerlo con el require como una vista nueva ya que se hace en home y en vista normal


echo "<h3>Listado de los libros</h3>";
// consulta con la que cojo todos los libros
try {
    $sentencia = $conexion->prepare("select * from libros");
    $sentencia->execute();
} catch (PDOException $e) {
    session_destroy();
    unset($conexion);
    die("<p>No he podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
}

// muestro los libros con el bucle
while ($tupla = $sentencia->fetch(PDO::FETCH_ASSOC)) {
    echo "<div class='fotos'>";
    echo "<img src='img/" . $tupla["portada"] . "' alt='imagen libro' title='imagen libro'><br>";
    echo $tupla["titulo"] . " - " . $tupla["precio"] . "€";
    echo "</div>";
}

// libero el resultado
unset($resultado);
