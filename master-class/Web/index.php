<?php
session_name("Profesores2_SW");
session_start();

require "src/ctes_funciones.php";

if (isset($_POST["btnSalir"])) {
    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "GET", array("api_session" => $_SESSION["api_session"]));
    session_destroy();
    header("Location:index.php");
    exit;
}

if (isset($_SESSION["usuario"])) {
    // Logueado
    // Seguridad
    $salto = 'index.php';
    require "src/seguridad.php";
    // Tipos
    if ($datos_usuario_logueado->tipo == "normal") {
        require "vistas/vista_normal.php";
    } else {
        require "vistas/vista_admin.php";
    }
} else {
    // No estoy logueado
    require "vistas/vista_login.php";
}
