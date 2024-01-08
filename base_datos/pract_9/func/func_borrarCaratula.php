<?php
// Si no está conectado me conecto
if (!isset($conexion)) {
    $conexion = conectarBD();
    if (is_string($conexion)) {
        session_destroy();
        die(error_page("Error intentando conectar a la BD", "<h2Error intentando conectar a la BD></h2><p>$conexion</p>"));
    }
}
// Cambio la foto que tuviera por la predeterminada
try {
    $consulta = "update peliculas set caratula='no_imagen.jpg' where idPelicula='" . $_POST["btnContBorrarCar"] . "'";
    $resultado = mysqli_query($conexion, $consulta);
    unlink("Img/" . $_POST["fotoAnt"]);
} catch (mysqli_sql_exception $e) {
    session_destroy();
    mysqli_close($conexion);
    die(error_page("Error intentando modificar la BD", "<h2Error intentando modificar la BD></h2><p>$conexion</p>"));
}

$_SESSION["msg_caratula"] = "<p>La carátula ha sido borrada con éxito</p>";
mysqli_close($conexion);
header("Location: index.php");
exit();
