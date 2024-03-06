<?php
$url = DIR_SERV . "/logueado";
$respuesta = consumir_servicios_REST($url, "POST", array("api_session" => $_SESSION["api_session"]));
$obj = json_decode($respuesta);

if (!$obj) {
    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "GET", array("api_session" => $_SESSION["api_session"]));
    session_destroy();
    die(error_page("ERROR", "<h1>ERROR</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
}

if (isset($obj->error)) {
    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "GET", array("api_session" => $_SESSION["api_session"]));
    session_destroy();
    die(error_page("ERROR", "<h1>ERROR</h1><p>" . $obj->error . "</p>"));
}

if (isset($obj->no_auth)) {
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
    header("Location: index.php");
    exit;
}

if (isset($obj->mensaje)) {
    session_unset();
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location: index.php");
    exit;
}

$datos_usuario_logueado = $obj->usuario;

if (time() - $_SESSION["ult_acc"] > MINUTOS * 60) {
    session_unset();
    $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado";
    header("Location: index.php");
    exit;
}
$_SESSION["ult_acc"] = time();
