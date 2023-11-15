<?php
require "src/aux_bd";

// Compruebo el formulario de insertar
if (isset($_POST["btnGuardarInsertar"])){
    $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 50;
    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 30;
    if (!$error_usuario){
        if (!isset($bd)){
            $bd = conectarBD();
            if (is_string($bd)) {
                error_page("Error conectando", "<h3>Error conectando a la BD: $bd</h3>");
                exit();
            }
        }
        $error_usuario = repetido($bd, "usuarios", "usuario", $_POST["usuario"]);
    }
    $error_psw = $_POST["psw"] == "" || strlen($_POST["psw"]) > 15;
    $error_dni = !preg_match("/^[0-9]{8}[A-Z]$/", $_POST["dni"]) || Letra_NIF($_POST["dni"], substr($_POST["dni"], 0, strlen($_POST["dni"]) - 1)) == substr($_POST["dni"], -1);
    if (!$error_dni){
        if (!isset($bd)){
            $bd = conectarBD();
            if (is_string($bd)) {
                error_page("Error conectando", "<h3>Error conectando a la BD: $bd</h3>");
                exit();
            }
        }
        $error_dni = repetido($bd, "usuarios", "dni", $_POST["dni"]);
    }

    $error_foto = false;
    if (isset($_FILES["foto"])){
        $error_foto = !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024;
    }

    $error_form = $error_nombre || $error_usuario || $error_psw || $error_dni || $error_foto;
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
    </style>
</head>

<body>
    <h1>Práctica 8</h1>
    <?php
    if (isset($_POST["btnInsertar"]) || isset($_POST["btnGuardarInsertar"])) {
        require "vistas/vistaInsertar.php";
    }
    require "vistas/vistaTabla.php";
    ?>
</body>

</html>