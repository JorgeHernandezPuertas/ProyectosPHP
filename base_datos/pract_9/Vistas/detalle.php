<?php
if (!isset($conexion)) {
    $conexion = conectarBD();
    if (is_string($conexion)) {
        print "<p>Ha ocurrido un error conectando a la BD: $conexion</p>";
    }
}

try {
    $consulta = "select * from peliculas where idPelicula='" . $_POST["btnDetalles"] . "'";
    $resultado = mysqli_query($conexion, $consulta);
} catch (mysqli_sql_exception $e) {
    print "<p>Ha ocurrido un error obteniendo los datos desde la BD</p>";
}
$n_rows = mysqli_num_rows($resultado);
if (isset($resultado) && $n_rows > 0) {
    $tupla = mysqli_fetch_assoc($resultado);
?>
    <h4>Detalles de la película con id: <?php print $_POST["btnDetalles"] ?></h4>
    <p><strong>Título:</strong> <?php print $tupla["titulo"] ?></p>
    <p><strong>Director:</strong> <?php print $tupla["director"] ?></p>
    <p><strong>Sinopsis:</strong> <?php print $tupla["sinopsis"] ?></p>
    <p><strong>Temática:</strong> <?php print $tupla["tematica"] ?></p>
    <p><strong>Caratula:</strong><br> <img src="Img/<?php print $tupla["caratula"] ?>" alt="Imagen de la carátula" class="perfil" ></p>
<?php
} else if ($n_rows <= 0) {
    print "<p>La película seleccionada ha sido borrada.</p>";
}
?>