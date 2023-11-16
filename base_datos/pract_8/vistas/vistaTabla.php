<h2>Listado de usuarios</h2>
    <?php
    // Me conecto a la BD
    if (!isset($bd)){
        $bd = conectarBD();
        if (is_string($bd)) {
            die("<h4>Ha ocurrido un error conectandose a la BD:</h4><p>$bd</p>");
        }
    }

    // Hago una consulta a la BD para obtener los datos de la tabla
    try {
        $consulta = "select * from usuarios";
        $resultado = mysqli_query($bd, $consulta);
    } catch (mysqli_sql_exception $e) {
        mysqli_close($bd);
        print "<p class='error'>Ha habido un error obtenido los datos de la tabla: " . $e->getMessage() . "</p>";
    }

    // Creo la tabla
    print "<table>";
    // Imprimo la cabecera
    print "<tr><th>#</th><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button type='submit' name='btnInsertar' class='enlace'>Usuario+</button></form></th></tr>";
    // Imprimo los datos obtenidos
    for ($i = 0; $i < mysqli_num_rows($resultado); $i++) {
        $fila = mysqli_fetch_assoc($resultado);
        print "<tr>";
        print "<td>" . $fila["id_usuario"] . "</td><td><img src='Img/" . $fila["foto"] . "' ></td><td><form action='index.php' method='post' ><button type='submit' class='enlace' name='btnDetalle' value='" . $fila["id_usuario"] . "' >" . $fila["nombre"] . "</button></td>";
        print "<td><button type='submit' name='btnBorrar' value='" . $fila["id_usuario"] . "' class='enlace'>Borrar</button><input type='hidden' name='foto' value='".$fila["foto"]."' > - ";
        print "<button type='submit' name='btnEditar' value='" . $fila["id_usuario"] . "' class='enlace'>Editar</button><input type='hidden' name='foto' value='".$fila["foto"]."' ></form></td>";
        print "</tr>";
    }
    print "</table>";
    mysqli_free_result($resultado);
    mysqli_close($bd);