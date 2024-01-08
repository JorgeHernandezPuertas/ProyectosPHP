<?php
session_name("examen3_22_23");
session_start();

if (isset($_POST["btnSalir"])){
    session_destroy();
    header("Location: ../index.php");
    exit;
}

if (isset($_SESSION["user"]) && $_SESSION["tipo"] == "admin" ){
    require "../src/func_const.php";
    require "../src/seguridadAdmin.php";

    require "../vistas/vistaAdmin.php";
} else {
    header("Location: ../index.php");
    exit;
}

?>