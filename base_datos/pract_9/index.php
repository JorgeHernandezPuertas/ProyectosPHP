<?php
session_name("pract9");
session_start();
require "src/aux_bd.php";

// Inserción
if (isset($_POST["btnInsertarConf"])) {
    require "func/func_insert.php";
}

// Borrado
if (isset($_POST["btnBorrarCont"])){
    require "func/func_borrar.php";
}

// Modificación
if (isset($_POST["btnEditar"])){
    require "func/func_mod.php";
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD videoclub - Práctica 9</title>
    <style>
        body {
            padding-bottom: 5rem;
        }

        table,
        th,
        td {
            border-collapse: collapse;
            border: 1px solid black;
        }

        table {
            width: 80%;
            margin: 0 auto;
        }

        th,
        td {
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

    // Pongo los mensajes de sesión
    if (isset($_SESSION["msg_ins"])) {
        print $_SESSION["msg_ins"];
        unset($_SESSION["msg_ins"]);
    } else if (isset($_SESSION["msg_borrar"])){
        print $_SESSION["msg_borrar"];
        unset($_SESSION["msg_borrar"]);
    }

    // Pongo las diferentes operaciones CRUD
    if (isset($_POST["btnInsertar"]) || isset($_POST["btnInsertarConf"])) {
        require "Vistas/insertar.php";
    } else if (isset($_POST["btnDetalles"])) {
        require "Vistas/detalle.php";
    } else if (isset($_POST["btnBorrar"])){
        require "Vistas/borrar.php";
    } else if (isset($_POST["btnEditar"])){
        require "Vistas/modificar.php";
    }

    mysqli_close($conexion);
    ?>

</body>

</html>