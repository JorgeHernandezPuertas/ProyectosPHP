<?php
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

$libros_totales = $sentencia->rowCount();

if (isset($_POST["btnBuscar"])) { // Si hay búsquedas
    try {
        $sentencia = $conexion->prepare("select * from libros where titulo like  '" . $_POST["busqueda"] . "%'");
        $sentencia->execute();
    } catch (PDOException $e) {
        session_destroy();
        unset($conexion);
        die("<p>No he podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }
} else { // Si no hay búsqueda
    try {
        $sentencia = $conexion->prepare("select * from libros limit " . ($_SESSION["pagina"] - 1) * $_SESSION["longitud"] . "," . $_SESSION["longitud"] . " ");
        $sentencia->execute();
    } catch (PDOException $e) {
        session_destroy();
        unset($conexion);
        die("<p>No he podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }
}


print "<form id='pre-fotos' action='index.php' method='post' >";
print "<div id='numero-fotos'>";
print "<label for='num'>Número de imagenes a visionar: </label>";
print "<select id='num' name='num'>";
?>
<option value='3'>3</option>
<option value='6' <?php if ($_SESSION["longitud"] === 6) print "selected" ?>>6</option>
<option value='<?php print $libros_totales ?>' <?php if ($_SESSION["longitud"] === $libros_totales) print "selected" ?>>todo</option>
<?php
print "</select>";
print "<button name='btnNum'>Cambiar</button>";
print "</div>";
print "<div id='buscador'>";
print "<input name='busqueda' placeholder='Busca tu libro aqui...' value='" . (isset($_POST["busqueda"]) ? $_POST["busqueda"] : "") . "'  /> ";
print "<button name='btnBuscar'>Buscar</button>";
print "</div>";
print "</form>";


// muestro los libros con el bucle
if ($sentencia->rowCount() > 0) {
    print "<div>";
    while ($tupla = $sentencia->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='fotos'>";
        echo "<img src='img/" . $tupla["portada"] . "' alt='imagen libro' title='imagen libro'><br>";
        echo $tupla["titulo"] . " - " . $tupla["precio"] . "€";
        echo "</div>";
    }
    print "</div>";
    // Paginación
    print "<form class='paginas' method='post' action='index.php' >";
    if ($_SESSION["longitud"] !== $libros_totales) {
        $num_paginas = intval($libros_totales / $_SESSION["longitud"]) + 1;
        if ($_SESSION["pagina"] != 1) {
            $valor = $_SESSION["pagina"] - 1;
            print "<button name='pagina' value='1' > << </button> ";
            print "<button name='pagina' value='$valor' > < </button> ";
        }
        for ($i = 1; $i <= $num_paginas; $i++) {
            $boton = $_SESSION["pagina"] == $i ? "<button name='pagina' disabled value='$i' >$i</button> " : "<button name='pagina' value='$i' >$i</button> ";
            print $boton;
        }
        if ($_SESSION["pagina"] != $num_paginas) {
            $valor = $_SESSION["pagina"] + 1;
            print "<button name='pagina' value='$valor' > > </button> ";
            print "<button name='pagina' value='$num_paginas' > >> </button>";
        }
    }

    print "</form>";
} else {
    print "<p id='sin-libros'>No hay resultados de libros<p>";
}

// libero el resultado
unset($resultado);
