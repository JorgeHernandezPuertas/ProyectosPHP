<?php
$error_titulo = $_POST["titulo"] == "" || strlen($_POST["titulo"]) > 15;
$error_director = $_POST["director"] == "" || strlen($_POST["director"]) > 20;
$error_sinopsis = $_POST["sinopsis"] == "";
$error_tematica = $_POST["tematica"] == "" || strlen($_POST["director"]) > 15;
$error_caratula = false;
if ($_FILES["caratula"]["name"] != "") {
    $error_caratula = !getimagesize($_FILES["caratula"]["tmp_name"]) || !explode(".", $_FILES["caratula"]["name"]);
}
$error_form = $error_titulo || $error_director || $error_sinopsis || $error_tematica || $error_caratula;

// Cuando no haya error en el formulario inserto el usuario
if (!$error_form) {
    // Inserto el usuario
    if (!isset($conexion)) {
        $conexion = conectarBD();
        if (is_string($conexion)) {
            session_destroy();
            die(error_page("Ha ocurrido un error conectando a la BD", "<p>Ha ocurrido un error conectando a la BD: $conexion</p>"));
        }
    }
    try {
        $consulta = "insert into peliculas (titulo, director, sinopsis, tematica) values ('" . $_POST["titulo"] . "', '" . $_POST["director"] . "', '" . $_POST["sinopsis"] . "', '" . $_POST["tematica"] . "')";
        mysqli_query($conexion, $consulta);
    } catch (mysqli_sql_exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die(error_page("Ha ocurrido un error insertando a la BD", "<p>Ha ocurrido un error insertando a la BD: $e</p>"));
    }

    // Si tiene foto le pongo la foto
    if ($_FILES["caratula"]["name"] != "") {
        $ext = "";
        if ($partes = explode(".", $_FILES["caratula"]["name"])) {
            $ext = "." . end($partes);
        }
        $id_car = mysqli_insert_id($conexion);
        $caratula = "caratula$id_car$ext";
        @$var = move_uploaded_file($_FILES["caratula"]["tmp_name"], "Img/$caratula");
        if ($var) { // Si he creado el archivo con éxito le modifico la carátula en la BD
            try {
                $consulta = "update peliculas set caratula='$caratula' where idPelicula='$id_car'";
                mysqli_query($conexion, $consulta);
                $mensaje_ins = "<p class='mensaje'>Se ha insertado el nuevo usuario con éxito</p>";
            } catch (mysqli_sql_exception $e) {
                unlink("Img/$caratula");
                mysqli_close($conexion);
                $mensaje_ins = "<p class='mensaje'>Ha ocurrido un error y se ha insertado el usuario con la carátula predeterminada.</p>";
            }
        } else {
            // No se ha creado el archivo
            $mensaje_ins = "<p class='mensaje'>Ha ocurrido un error y se ha insertado el usuario con la carátula predeterminada.</p>";
        }
    }
    $_SESSION["msg_ins"] = $mensaje_ins;
    header("Location: index.php");
    exit();
}
?>