<?php
session_name("servicios-web-ejercicio3");
session_start();
require "./src/utilidad.php";

if (isset($_SESSION["usuario"])) {
  if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location: index.php");
    exit;
  }

  require "./seguridad/seguridad.php";

  if ($datos_usuario_log->tipo === "normal") {
    require "./vistas/normal.php";
  } else if ($datos_usuario_log->tipo === "admin") {
    require "./vistas/admin.php";
  }
} else {
  if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] === "" || strlen($_POST["usuario"]) > 30;
    $error_psw = $_POST["psw"] === "" || strlen($_POST["psw"]) > 16;
    $error_form = $error_usuario || $error_psw;

    if (!$error_form) {
      $respuesta = consumir_servicios_REST(DIR_SERV . "/login", "post", array("usuario" => $_POST["usuario"], "clave" => md5($_POST["psw"])));
      $obj = json_decode($respuesta);
      if (!$obj) {
        session_destroy();
        die(error_page("App Login SW", "<h1>App Login SW</h1>" . $respuesta));
      } else if (isset($obj->mensaje_error)) {
        session_destroy();
        die(error_page("App Login SW", "<h1>App Login SW</h1><p>$obj->mensaje_error</p>"));
      }

      if (isset($obj->mensaje)) {
        $error_usuario = true;
      } else {
        $_SESSION["usuario"] = $obj->usuario->usuario;
        $_SESSION["psw"] = $obj->usuario->clave;
        $_SESSION["ult_accion"] = time();
        header("Location: index.php");
        exit;
      }
    }
  }
  require "./vistas/login.php";
}
