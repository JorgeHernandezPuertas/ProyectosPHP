<?php
$respuesta = consumir_servicios_REST(DIR_SERV . "/login", "post", array("usuario" => $_SESSION["usuario"], "clave" => $_SESSION["psw"]));
$obj = json_decode($respuesta);
if (!$obj) {
  session_destroy();
  die(error_page("App Login SW", "<h1>App Login SW</h1>" . $respuesta));
} else if (isset($obj->mensaje_error)) {
  session_destroy();
  die(error_page("App Login SW", "<h1>App Login SW</h1><p>$obj->mensaje_error</p>"));
}

// Si existe le han baneado
if (isset($obj->mensaje)) {
  session_unset();
  $_SESSION["mensaje"] = "Usted ya no se encuentra registrado en la base de datos";
  header("Location: index.php");
  exit;
}

$datos_usuario_log = $obj->usuario;

if (time() - $_SESSION["ult_accion"] > MINUTOS * 60) {
  session_unset();
  $_SESSION["mensaje"] = "El tiempo de sesión ha inspirado";
  header("Location: index.php");
  exit;
}

$_SESSION["ult_accion"] = time();
