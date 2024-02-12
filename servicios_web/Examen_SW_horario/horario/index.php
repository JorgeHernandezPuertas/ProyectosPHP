<?php
session_name("examen_horarios_sw_usuario");
session_start();
require "src/utils.php";

if (isset($_POST["btnSalir"])) {
  consumir_servicios_REST(DIR_SERV . "/salir", "post", array("api_session" => $_SESSION["api_session"]));
  session_destroy();
  header("Location: index.php");
  exit;
}

if (isset($_SESSION["usuario"])) {
  require "src/seguridad.php";

  if ($datos_usuario_log->tipo === "admin") {
    require "vistas/admin.php";
  } else {
    require "vistas/normal.php";
  }
} else {
  require "vistas/home.php";
}
