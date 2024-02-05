<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

// a)
$app->post("/login", function ($req) {
    print json_encode($req->getParam("lector"), $req->getParam("clave"));
});

// b)
$app->get("logueado", function ($req) {
    session_id($req->getParam("api_session"));
    session_start();
    if (isset($_SESSION["lector"])) {
        print json_encode(logueado($_SESSION["lector"], $_SESSION["clave"]));
    } else {
        print json_encode(array("mensaje" => "El api session no es válido."));
    }
});


// Una vez creado servicios los pongo a disposición
$app->run();
