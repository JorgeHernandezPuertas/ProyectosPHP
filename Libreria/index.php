<?php
session_name("examen3_22_23");
session_start();

require "src/func_const.php";

if (isset($_SESSION["mensajeInactivo"])) {
    require "vistas/vistaInactividad.php";
} else if (isset($_SESSION["mensajeBaneado"])) {
    require "vistas/vistaBaneado.php";
} else if (isset($_SESSION["user"])) {
    require "src/seguridad.php";

    if ($datos_lector["tipo"] == "admin") {
        header("Location: admin/gest_libros.php");
    } else {
        require "vistas/vistaInicial.php";
    }
} else {
    require "vistas/vistaInicial.php";
}
