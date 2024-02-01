<?php
session_name("actividad5-sw");
session_start();
require "utils.php";

if (isset($_SESSION["usuario"])) {
    if (isset($_POST["btnSalir"])) {
        $datos = array("api_key");
        consumir_servicios_REST(DIR_SERV . "/salir", "post", $datos);
        session_destroy();
        header("Location:index.php");
        exit;
    }

    require "./src/seguridad.php";

    if ($datos_usuario->tipo === "admin")
        require './vistas/admin.php';
    else
        require './vistas/normal.php';
} else {
    require './vistas/login.php';
}
