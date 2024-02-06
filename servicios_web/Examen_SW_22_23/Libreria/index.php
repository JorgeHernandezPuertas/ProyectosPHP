<?php
session_name("liberia-SW-practica-examen");
session_start();

require "./src/utils.php";

if (isset($_SESSION["usuario"])) {
    require "./src/seguridad.php";

    if ($_SESSION["tipo"] === "admin") {
        header("Location: ./admin/gest_libros.php");
        exit;
    } else {
        require "./vistas/normal.php";
    }
} else {
    require "./vistas/home.php";
}
