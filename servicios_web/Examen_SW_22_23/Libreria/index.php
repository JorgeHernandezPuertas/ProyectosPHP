<?php
session_name("liberia-SW-practica-examen");
session_start();

require "./src/utils.php";

if (isset($_POST["btnSalir"])) {
    consumir_servicios_REST(DIR_SERV . "/salir", "post");
    session_destroy();
    header("Location: index.php");
    exit;
}

if (isset($_SESSION["lector"])) {
    $salto = "index.php";
    require "./src/seguridad.php";

    if ($datos_usuario_log->tipo === "admin") {
        header("Location: ./admin/gest_libros.php");
        exit;
    } else {
        require "./vistas/normal.php";
    }
} else {
    require "./vistas/home.php";
}
