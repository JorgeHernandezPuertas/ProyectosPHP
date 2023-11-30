<?php
if (isset($_POST["btnEditar"]))
    $id_pelicula = $_POST["btnEditar"];
else if (isset($_POST["btnEditarCont"]))
    $id_pelicula = $_POST["btnEditarCont"];
else
    $id_pelicula = $_POST["eliminarCar"];

if (!isset($conexion)) {
    $conexion = conectarBD();
    if (is_string($conexion)) {
        print "<p>Ha ocurrido un error conectando a la BD: $conexion</p>";
    }
}

try {
    $consulta = "select * from peliculas where idPelicula='" . $id_pelicula . "'";
    $resultado = mysqli_query($conexion, $consulta);
} catch (mysqli_sql_exception $e) {
    print "<p>Ha ocurrido un error obteniendo los datos desde la BD</p>";
}
$n_rows = mysqli_num_rows($resultado);
if ($n_rows > 0) { // Si no lo han borrado
    $tupla = mysqli_fetch_assoc($resultado);
    mysqli_free_result($resultado);
?>
    <form id="editar" action="index.php" method="post" enctype="multipart/form-data">
        <h4>Editar una Película</h4>
        <p>
            <label for="titulo">Título de la película</label><br>
            <input type="text" name="titulo" id="titulo" value="<?php print $tupla["titulo"] ?>">
            <?php
            if (isset($_POST["btnEditarCont"]) && $error_titulo) {
                if ($_POST["titulo"] == "") {
                    print "<span class='error' > * Campo obligatorio * </span>";
                } else {
                    print "<span class='error' > * Has superado el número máximo de caracteres (15) * </span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="director">Director de la película</label><br>
            <input type="text" name="director" id="director" value="<?php print $tupla["director"] ?>">
            <?php
            if (isset($_POST["btnEditarCont"]) && $error_director) {
                if ($_POST["director"] == "") {
                    print "<span class='error' > * Campo obligatorio * </span>";
                } else {
                    print "<span class='error' > * Has superado el número máximo de caracteres (20) * </span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="tematica">Temática de la película</label><br>
            <input type="text" name="tematica" id="tematica" value="<?php print $tupla["tematica"] ?>">
            <?php
            if (isset($_POST["btnEditarCont"]) && $error_tematica) {
                if ($_POST["tematica"] == "") {
                    print "<span class='error' > * Campo obligatorio * </span>";
                } else {
                    print "<span class='error' > * Has superado el número máximo de caracteres (15) * </span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="sinopsis">Sinopsis de la película</label><br>
            <textarea name="sinopsis" id="sinopsis" cols="20" rows="7"><?php print $tupla["sinopsis"] ?></textarea>
            <?php
            if (isset($_POST["btnEditarCont"]) && $error_sinopsis) {
                print "<span class='error' > * Campo obligatorio * </span>";
            }
            ?>
        </p>
        <p>
            <label for="caratula">Cambiar carátula de la película: </label>
            <input type="file" name="caratula" id="caratula" accept="image/*">
            <?php
            if (isset($_POST["btnEditarCont"]) && $error_caratula) {
                if (!getimagesize($_FILES["caratula"]["tmp_name"])) {
                    print "<span class='error'> * El archivo subido no es una imagen * </span>";
                } else {
                    print "<span class='error'> * La imagen tiene que tener una extensión * </span>";
                }
            }
            ?>
        </p>
        <input type="hidden" name="fotoAnt" value="<?php print $_POST["fotoAnt"] ?>">
        <div id="car">
            <p>Carátula Actual</p>
            <img src="Img/<?php print $_POST["fotoAnt"] ?>" alt="Carátula de la película"><br>
            <?php
            if ($_POST["fotoAnt"] != "no_imagen.jpg") {
            ?>
                <button name="eliminarCar" value="<?php print $id_pelicula ?>">Eliminar Carátula</button>
            <?php
            }
            ?>

        </div>
        <p>
            <button name="btnEditarCont" value="<?php print $id_pelicula ?>">Editar película</button> <button>Atrás</button>
        </p>
    </form>
<?php
} else {
    print "<p>La película seleccionada fue borrada.</p>";
}
?>