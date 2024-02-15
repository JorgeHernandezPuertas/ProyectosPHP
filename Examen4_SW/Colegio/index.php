<?php
session_name("Examen4_SW_23_24");
session_start();

require "src/funciones_ctes.php";

if (isset($_POST["btnSalir"])) {
    $datos["api_session"] = $_SESSION["api_session"];
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos);
    session_destroy();
    header("Location:index.php");
    exit;
}

if (isset($_SESSION["usuario"])) {
    $salto = "index.php";
    require "src/seguridad.php";

    if ($datos_usuario_log->tipo == "alumno")
        require "vistas/vista_normal.php";
    else {
        header("Location:admin/index.php");
        exit;
    }
} else {
    require "vistas/vista_home.php";
}
