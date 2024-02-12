<?php
session_name("examen_horarios_sw");

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

$app->post("/login", function ($req) {
    $datos = array($req->getParam("usuario"), $req->getParam("clave"));
    return json_encode(login($datos));
});

$app->get("/logueado", function ($req) {
    $api_session = $req->getParam("api_session");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"])) {
        $datos = array($_SESSION["usuario"], $_SESSION["clave"]);
        return json_encode(logueado($datos));
    } else {
        return json_encode(array("no_auth" => "no tienes permisos para acceder a esta funcionalidad"));
    }
});

$app->get("/obtenerProfesores", function ($req) {
    $api_session = $req->getParam("api_session");
    session_id($api_session);
    session_start();
    if (isset($_POST["usuario"])) {
        return json_encode(obtenerProfesores());
    } else {
        return json_encode(array("no_auth" => "no tienes permisos para acceder a esta funcionalidad"));
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();
