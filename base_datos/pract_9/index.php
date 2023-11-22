<?php
require "src/aux_bd.php";

// Compruebo el formulario de inserción
if (isset($_POST["btnInsertarConf"])){
    $error_titulo = $_POST["titulo"] == "" || strlen($_POST["titulo"]) > 15;
    $error_director = $_POST["director"] == "" || strlen($_POST["director"]) > 20;
    $error_sinopsis = $_POST["sinopsis"] == "";
    $error_tematica = $_POST["tematica"] == "" || strlen($_POST["director"]) > 15;
    $error_caratula = false;
    if ($_FILES["caratula"]["name"] != ""){
        $error_caratula = !getimagesize($_FILES["caratula"]["tmp_name"]) || !explode(".", $_FILES["caratula"]["name"]);
    }
    $error_form = $error_titulo || $error_director || $error_sinopsis || $error_tematica || $error_caratula;

    // Cuando no haya error en el formulario inserto el usuario
    if (!$error_form) {
        // Inserto el usuario
        if (!isset($conexion)){
            $conexion = conectarBD();
        if (is_string($conexion)) {
            die(error_page("Ha ocurrido un error conectando a la BD", "<p>Ha ocurrido un error conectando a la BD: $conexion</p>"));
        }
        }
        try {
            $consulta = "insert into peliculas (titulo, director, sinopsis, tematica) values ('".$_POST["titulo"]."', '".$_POST["director"]."', '".$_POST["sinopsis"]."', '".$_POST["tematica"]."')";
            mysqli_query($conexion, $consulta);
        } catch (mysqli_sql_exception $e){
            mysqli_close($conexion);
            die(error_page("Ha ocurrido un error insertando a la BD", "<p>Ha ocurrido un error insertando a la BD: $e</p>"));
        }
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD videoclub - Práctica 9</title>
    <style>
        table, th, td {
            border-collapse: collapse;
            border: 1px solid black;
        }
        table {
            width: 80%;
            margin: 0 auto;
        }
        th, td {
            padding: 2px 8px;
            text-align: center;
        }
        .enlace {
            background-color: white;
            border: none;
            color: blue;
            text-decoration: underline;
        }
        img {
            width: 100px;
            height: auto;
        }
        .perfil {
            width: 300px;
        }
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Video Club</h1>
    <h2>películas</h2>
    <?php
    // Pongo la tabla
    require "Vistas/tabla.php";

    // Pongo las diferentes operaciones CRUD
    if (isset($_POST["btnInsertar"]) || isset($_POST["btnInsertarConf"])){
        require "Vistas/insertar.php";
    }

    mysqli_close($conexion);
    ?>
    
</body>

</html>