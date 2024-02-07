<?php
$url = DIR_SERV . "/logueado";
$datos = array("api_session" => $_SESSION["api_session"]);
$obj = json_decode(consumir_servicios_REST($url, "get", $datos));

if (!$obj) {
  session_destroy();
  die(error_page("Error consumiendo el servicio web", "<h2>Error consumiendo el servicio web</h2><p>$url</p>"));
} else if (isset($obj->error)) {
  session_destroy();
  die(error_page("Error consumiendo el servicio web", "<h2>Error consumiendo el servicio web</h2><p>$obj->error</p>"));
} else if (isset($obj->no_auth)) {
  session_unset();
  $_SESSION["seguridad"] = "El tiempo de sesión de la API ha expirado";
  header("Location: $salto");
  exit;
} else if (isset($obj->mensaje)) {
  session_unset();
  $_SESSION["seguridad"] = "Su usuario ya no se encuentra registrado en la BD";
  header("Location: $salto");
  exit;
}

if (time() - $_SESSION["ult_accion"] > MINUTOS * 60) {
  session_unset();
  $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
  header("Location: $salto");
  exit;
}

$_SESSION["ult_accion"] = time();

$datos_usuario_log = $obj->usuario;
