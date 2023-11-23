<?php
if(!isset($conexion)){
    $conexion = conectarBD();
    if (is_string($conexion)){
        session_destroy();
        die(error_page("Error conectando a la BD", "<p>Ha ocurrido un error haciendo la conexión con la BD</p>"));
    }
}
try {
    $consulta = "delete from peliculas where idPelicula='".$_POST["btnBorrarCont"]."'";
    mysqli_query($conexion, $consulta);
    unlink("Img/". $_POST["fotoAnt"]);
} catch (mysqli_sql_exception $e) {
    session_destroy();
    mysqli_close($conexion);
    die(error_page("Error borrando en la BD", "<p>Ha ocurrido un error borrando la película en la BD</p>"));
}
$_SESSION["msg_borrar"] = "<p class='mensaje'>Se ha borrado la película con éxito.</p>";
header("Location: index.php");
exit();
?>