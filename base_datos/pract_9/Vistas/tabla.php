<h4>Listado de películas</h4>
    <?php
    // Me conecto a la BD si no estoy conectado
    if (!isset($conexion)) {
        $conexion = conectarBD();
        if (is_string($conexion)) {
            print "<p>Ha ocurrido un error conectando a la BD: $conexion</p>";
        }
    }
    // Hago una búsqueda de todas la películas para listarlas en la tabla
    try {
        $consulta = "select * from peliculas";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (mysqli_sql_exception $e) {
        mysqli_close($conexion);
        die("<p>Ha ocurrido un error obteniendo los datos de la BD: $e</p>");
    }
    $num_filas = mysqli_num_rows($resultado);    
    ?>
    <table>
        <tr>
            <th>id</th>
            <th>Título</th>
            <th>Carátula</th>
            <th><form action="index.php" method="post"><button class="enlace" name="btnInsertar" >Películas +</button></form></th>
        </tr>
    <?php
    for ($i=0; $i < $num_filas; $i++) { 
        $tupla = mysqli_fetch_assoc($resultado);
        print "<tr><form action='index.php' method='post' >";
        print "<td>".$tupla["idPelicula"]."</td>";
        print "<td><button class='enlace' name='btnDetalles' value='".$tupla["idPelicula"]."' >".$tupla["titulo"]."</button></td>";
        print "<td><img src='Img/".$tupla["caratula"]."' alt='imagen de la carátula' title='Carátula' ></td>";
        print "<td><button class='enlace' name='btnBorrar' value='".$tupla["idPelicula"]."' >Borrar</button> - <button name='btnEditar' value='".$tupla["idPelicula"]."' class='enlace' >Editar</button>";
        print "<input type='hidden' name='fotoAnt' value='".$tupla["caratula"]."' ></td>";
        print "</form></tr>";
    }
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
    </table>