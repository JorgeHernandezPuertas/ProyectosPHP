<?php

// Compruebo que sigue en la bd este usuario
$url = DIR_SERV . "/logueado";
$datos = array("api_session" => $_SESSION["api_session"]);
$obj = json_decode(consumir_servicios_REST($url, "get", $datos));
if (!isset($obj)) {
  session_destroy();
  die(error_page("Práctica examen - horarios", "<h2>Error consumiendo el servicio</h2><p>En la url: $url</p>"));
} else if (isset($obj->error)) {
  session_destroy();
  die(error_page("Práctica examen - horarios", "<h2>Error consumiendo el servicio</h2><p>Error: $obj->error</p>"));
}

// Si no existe
if (isset($obj->mensaje)) {
  session_unset();
  $_SESSION["seguridad"] = "Tu usuario ya no se encuentra en la BD";
  header("Location: index.php");
  exit;
}

if (isset($obj->no_auth)) {
  session_unset();
  $_SESSION["seguridad"] = $obj->no_auth;
  header("Location: index.php");
  exit;
}

// Me guardo los datos del usuario
$datos_usuario_log = $obj->usuario;

// Compruebo el tiempo de inactividad
if (time() - $_SESSION["ult_accion"] > MINUTOS * 60) {
  session_unset();
  $_SESSION["seguridad"] = "Has excedido el tiempo de inactividad";
  header("Location: index.php");
  exit;
}
