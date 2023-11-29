<?php
if (isset($_POST["btnEditarCont"])) {

    $error_titulo = $_POST["titulo"] == "" || strlen($_POST["titulo"]) > 15;
    $error_director = $_POST["director"] == "" || strlen($_POST["director"]) > 20;
    $error_sinopsis = $_POST["sinopsis"] == "";
    $error_tematica = $_POST["tematica"] == "" || strlen($_POST["director"]) > 15;
    $error_caratula = false;
    if ($_FILES["caratula"]["name"] != "") {
        $error_caratula = !getimagesize($_FILES["caratula"]["tmp_name"]) || !explode(".", $_FILES["caratula"]["name"]);
    }
    $error_form = $error_titulo || $error_director || $error_sinopsis || $error_tematica || $error_caratula;

    if (!$error_form) {
        $id_pelicula = $_POST["btnEditarCont"];

        // Si sube una foto nueva
        if ($_FILES["caratula"]["name"] != "") {
            $partes = explode(".", $_FILES["caratula"]["name"]);
            $ext = "." . end($partes);
            $nombreNuevo = "caratula" . $_POST["btnEditarCont"] . "$ext";
            @$var = move_uploaded_file($_FILES["caratula"]["tmp_name"], "Img/$nombreNuevo");
            if ($var) { // Borro la caratula anterior si no es la predeterminada
                // Modifico con carátula
                if (!isset($conexion)) {
                    $conexion = conectarBD();
                    if (is_string($conexion)) {
                        unlink("Img/$nombreNuevo");
                        session_destroy();
                        die(error_page("Error conectando a la BD", "<h3>Ha ocurrido un error estableciendo la conexión en la BD</h3><p>$conexion</p>"));
                    }
                }
                try {
                    $consulta = "update peliculas set titulo='" . $_POST["titulo"] . "', director='" . $_POST["director"] . "', sinopsis='" . $_POST["sinopsis"] . "', tematica='" . $_POST["tematica"] . "', caratula='$nombreNuevo' where idPelicula='$id_pelicula'";
                    $resultado = mysqli_query($conexion, $consulta);
                    if ($_POST["fotoAnt"] != "no_imagen.jpg"){
                        unlink("Img/" . $_POST["fotoAnt"]);
                    }
                } catch (mysqli_sql_exception $e) {
                    session_destroy();
                    mysqli_close($conexion);
                    die(error_page("Error conectando a la BD", "<h3>Ha ocurrido un error modificando en la BD</h3><p>$e</p>"));
                }
            } else {
                session_destroy();
                mysqli_close($conexion);
                die(error_page("Error conectando a la guardo la carátula", "<h3>Ha ocurrido un error guardando la carátula en el servidor</h3><p>$e</p>"));
            }
        } else {
            // Modifico sin caratula nueva
            if (!isset($conexion)) {
                $conexion = conectarBD();
                if (is_string($conexion)) {
                    session_destroy();
                    die(error_page("Error conectando a la BD", "<h3>Ha ocurrido un error estableciendo la conexión en la BD</h3><p>$conexion</p>"));
                }
            }
            try {
                $consulta = "update peliculas set titulo='" . $_POST["titulo"] . "', director='" . $_POST["director"] . "', sinopsis='" . $_POST["sinopsis"] . "', tematica='" . $_POST["tematica"] . "' where idPelicula='$id_pelicula'";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (mysqli_sql_exception $e) {
                session_destroy();
                mysqli_close($conexion);
                die(error_page("Error conectando a la BD", "<h3>Ha ocurrido un error modificando en la BD</h3><p>$e</p>"));
            }
        }

        $_SESSION["modificar"] = "<p>Se ha modifica la pelicula con id $id_pelicula con éxito</p>";
        mysqli_close($conexion);
        header("Location: index.php");

    }
}
