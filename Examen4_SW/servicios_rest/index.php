<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


// a)
$app->post('/login', function ($request) {
    $datos = array($request->getParam("usuario"), $request->getParam("clave"));
    print json_encode(login($datos));
});

// b)
$app->get("/logueado", function ($req) {
    $api_session = $req->getParam("api_session");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"])) {
        print json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        print json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// c)
$app->post("/salir", function ($req) {
    $api_session = $req->getParam("api_session");
    session_id($api_session);
    session_start();
    session_destroy();
    print json_encode(array("log_out" => "Cerrada sesión en la API"));
});

// d)
$app->get("/alumnos", function ($req) {
    $api_session = $req->getParam("api_session");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] === "tutor") {
        print json_encode(obtenerAlumnos());
    } else {
        session_destroy();
        print json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// e)
$app->get("/notasAlumno/{cod_alu}", function ($req) {
    $api_session = $req->getParam("api_session");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"])) {
        $cod_alu = $req->getAttribute("cod_alu");
        print json_encode(obtenerAsignaturasEvaluadas($cod_alu));
    } else {
        session_destroy();
        print json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});


// f)
$app->get("/NotasNoEvalAlumno/{cod_alu}", function ($req) {
    $api_session = $req->getParam("api_session");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] === "tutor") {
        $cod_alu = $req->getAttribute("cod_alu");
        print json_encode(obtenerAsignaturasNoEvaluadas($cod_alu));
    } else {
        session_destroy();
        print json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// g)
$app->delete("/quitarNota/{cod_alu}", function ($req) {
    $api_session = $req->getParam("api_session");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] === "tutor") {
        $cod_alu = $req->getAttribute("cod_alu");
        $cod_asig = $req->getParam("cod_asig");
        print json_encode(quitarNota($cod_alu, $cod_asig));
    } else {
        session_destroy();
        print json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// h)
$app->post("/ponerNota/{cod_alu}", function ($req) {
    $api_session = $req->getParam("api_session");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] === "tutor") {
        $cod_alu = $req->getAttribute("cod_alu");
        $cod_asig = $req->getParam("cod_asig");
        print json_encode(ponerNota($cod_alu, $cod_asig));
    } else {
        session_destroy();
        print json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// i)
$app->put("/cambiarNota/{cod_alu}", function ($req) {
    $api_session = $req->getParam("api_session");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] === "tutor") {
        $cod_alu = $req->getAttribute("cod_alu");
        $cod_asig = $req->getParam("cod_asig");
        $nota = $req->getParam("nota");
        print json_encode(cambiarNota($cod_alu, $cod_asig, $nota));
    } else {
        session_destroy();
        print json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();
