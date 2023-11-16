<?php
require "src/aux_bd.php";

// Compruebo el formulario de insertar
if (isset($_POST["btnGuardarInsertar"])) {
    $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 50;
    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 30;
    if (!$error_usuario) {
        if (!isset($bd)) {
            $bd = conectarBD();
            if (is_string($bd)) {
                error_page("Error conectando", "<h3>Error conectando a la BD: $bd</h3>");
                exit();
            }
        }
        $error_usuario = repetido($bd, "usuarios", "usuario", $_POST["usuario"]);
    }
    $error_psw = $_POST["psw"] == "" || strlen($_POST["psw"]) > 15;
    $dni_mayus = strtoupper($_POST["dni"]);
    $error_dni = !preg_match("/^[0-9]{8}[A-Z]$/", $dni_mayus) || !(LetraNIF(substr($dni_mayus, 0, 8)) == substr($dni_mayus, -1));
    if (!$error_dni) {
        if (!isset($bd)) {
            $bd = conectarBD();
            if (is_string($bd)) {
                error_page("Error conectando", "<h3>Error conectando a la BD: $bd</h3>");
                exit();
            }
        }
        $error_dni = repetido($bd, "usuarios", "dni", $dni_mayus);
    }

    $error_foto = false;
    if ($_FILES["foto"]["tmp_name"] != "") {
        $error_foto = !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024 || !explode(".", $_FILES["foto"]["name"]);
    }

    $error_form = $error_nombre || $error_usuario || $error_psw || $error_dni || $error_foto;

    // Si no hay error en el formulario, inserto el usuario nuevo en la BD
    if (!$error_form) {
        try {
            $consulta = "insert into usuarios (usuario, clave, nombre, dni, sexo) values ('" . $_POST["usuario"] . "', '" . md5($_POST["psw"]) . "', '" . $_POST["nombre"] . "', '" . $dni_mayus . "', '" . $_POST["sexo"] . "')";
            mysqli_query($bd, $consulta);
        } catch (mysqli_sql_exception $e) {
            mysqli_close($bd);
            die(error_page("Error insertando", "<h3>Error insertando el nuevo usuario a la BD: $e</h3>"));
        }

        // Si ha subido foto hago un update al insertado, para ponerle la foto. Esto lo hago para poder ponerle el num de id a la foto en el nombre
        if ($_FILES["foto"]["tmp_name"] != "") {
            $partes = explode(".", $_FILES["foto"]["name"]);
            $ext = "." . end($partes);
            $numero_foto = mysqli_insert_id($bd);
            $nom_foto = "foto_perfil" . $numero_foto . $ext;

            // Una vez insertado en la BD, guardo la imagen en la BD
            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "Img/$nom_foto");
            if ($var) { // Una vez subida la foto al servidor updateo la foto del usuario
                try {
                    $consulta = "update usuarios set foto='$nom_foto' where id_usuario='$numero_foto'";
                    mysqli_query($bd, $consulta);
                } catch (mysqli_sql_exception $e) {
                    unlink("Img/$nom_foto"); // Borro la foto si falla el updateo
                    mysqli_close($bd);
                    die(error_page("Error modificando", "<h3>Error modificando la foto del nuevo usuario a la BD: $e</h3>"));
                }
            } else {
                die(error_page("Error subiendo la imagen", "<h3>Ha ocurrido un error subiendo la imagen al servidor.</h3>"));
            }
        }

        header("Location:index.php");
        exit();
    }
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 8 - CRUD</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
        }

        td {
            padding: 1rem;
        }

        th {
            background-color: #CCC;
        }

        img {
            width: 50px;
            height: auto;
        }

        .enlace {
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }

        .error {
            color: red;
        }

        .foto-perfil {
            width: 200px;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Práctica 8</h1>
    <?php
    if (isset($_POST["btnInsertar"]) || isset($_POST["btnGuardarInsertar"])) {
        require "vistas/vistaInsertar.php";
    } else if (isset($_POST["btnDetalle"])) {
        require "vistas/vistaDetalle.php";
    } else if (isset($_POST["btnBorrar"]) || isset($_POST["btnBorrarCont"])) {
        require "vistas/vistaBorrar.php";
    }
    require "vistas/vistaTabla.php";
    ?>
</body>

</html>