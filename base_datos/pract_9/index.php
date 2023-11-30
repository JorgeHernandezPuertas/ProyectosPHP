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
if (isset($_POST["btnEditarCont"])){
    require "func/func_mod.php";
}

// Borrado carátula
if (isset($_POST["btnContBorrarCar"])){
    require "func/func_borrarCaratula.php";
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

        form#editar {
            display: flex;
            flex-flow: column;
            align-items: flex-start;
            width: 100%;
        }

        div#car {
            display: flex;
            flex-flow: column;
            align-items: center;
            width:20rem;
            position: absolute;
            margin-left: 35rem;
            margin-top:2rem;
        }
        div#car > img {
            width: 300px;
            height: auto;
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
    } else if (isset($_SESSION["modificar"])){
        print $_SESSION["modificar"];
        unset($_SESSION["modificar"]);
    } else if (isset($_SESSION["msg_caratula"])){
        print $_SESSION["msg_caratula"];
        unset($_SESSION["msg_caratula"]);
    }

    // Pongo las diferentes operaciones CRUD
    if (isset($_POST["btnInsertar"]) || isset($_POST["btnInsertarConf"])) {
        require "Vistas/insertar.php";
    } else if (isset($_POST["btnDetalles"])) {
        require "Vistas/detalle.php";
    } else if (isset($_POST["btnBorrar"])){
        require "Vistas/borrar.php";
    } else if (isset($_POST["btnEditar"]) || isset($_POST["btnEditarCont"])){
        require "Vistas/modificar.php";
    } else if (isset($_POST["eliminarCar"])) {
        require "Vistas/borrarCaratula.php";
    }

    mysqli_close($conexion);
    ?>

</body>

</html>