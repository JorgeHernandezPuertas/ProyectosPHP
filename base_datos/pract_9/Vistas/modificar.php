<?php
if (!isset($conexion)) {
    $conexion = conectarBD();
    if (is_string($conexion)) {
        print "<p>Ha ocurrido un error conectando a la BD: $conexion</p>";
    }
}

try {
    $consulta = "select * from peliculas where idPelicula='" . $_POST["btnEditar"] . "'";
    $resultado = mysqli_query($conexion, $consulta);
} catch (mysqli_sql_exception $e) {
    print "<p>Ha ocurrido un error obteniendo los datos desde la BD</p>";
}
$n_rows = mysqli_num_rows($resultado);
if ($n_rows > 0) { // Si no lo han borrado
    $tupla = mysqli_fetch_assoc($resultado);
    mysqli_free_result($resultado);
    if (isset($_POST["btnEditar"]))
        $id_pelicula = $_POST["btnEditar"];
    else if (isset($_POST["btnEditarCont"]))
        $id_pelicula = $_POST["btnEditarCont"];
    else
        $id_pelicula = $_POST["eliminarCar"];
?>
    <form id="editar" action="index.php" method="post" >
        <h4>Editar una Película</h4>
        <p>
            <label for="titulo">Título de la película</label><br>
            <input type="text" name="titulo" id="titulo" value="<?php print $tupla["titulo"] ?>" >
        </p>
        <p>
            <label for="director">Director de la película</label><br>
            <input type="text" name="director" id="director" value="<?php print $tupla["director"] ?>" >
        </p>
        <p>
            <label for="tematica">Temática de la película</label><br>
            <input type="text" name="tematica" id="tematica" value="<?php print $tupla["tematica"] ?>" >
        </p>
        <p>
            <label for="sinopsis">Sinopsis de la película</label><br>
            <textarea name="sinopsis" id="sinopsis" cols="20" rows="7"><?php print $tupla["sinopsis"] ?></textarea>
        </p>
        <p>
            <label for="caratula">Cambiar carátula de la película: </label>
            <input type="file" name="caratula" id="caratula" accept="image/*" >
        </p>
        <p id="car">
            <p>Carátula Actual</p>
            <img src="Img/<?php print $_POST["fotoAnt"] ?>" alt="Carátula de la película"><br>
            <button name="eliminarCar" value="<?php print $id_pelicula ?>">Eliminar Carátula</button>
        </p>
        <p>
            <button name="btnEditarCont" value="<?php print $id_pelicula ?>">Editar película</button> <button>Atrás</button>
        </p>
</form>
<?php
} else {
    print "<p>La película seleccionada fue borrada.</p>";
}
?>