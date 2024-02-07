<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

// a)
$app->post("/login", function ($req) {
    print json_encode(comprobarLogin($req->getParam("lector"), $req->getParam("clave")));
});

// b)
$app->get("/logueado", function ($req) {
    session_id($req->getParam("api_session"));
    session_start();
    if (isset($_SESSION["lector"])) {
        print json_encode(logueado($_SESSION["lector"], $_SESSION["clave"]));
    } else {
        session_destroy();
        print json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// c)
$app->post("/salir", function ($req) {
    $api_key = $req->getParam("api_session");
    session_id($api_key);
    session_start();
    session_destroy();
    print json_encode(array("log_out" => "Cerrada sesión en la API"));
});

// d)
$app->get("/obtenerLibros", function () {
    print json_encode(obtenerLibros());
});

// e)
$app->post("/crearLibro", function ($req) {
    $api_key = $req->getParam("api_session");
    session_id($api_key);
    session_start();
    if (isset($_SESSION["lector"])) {
        $datos = array(
            "referencia" => $req->getParam("referencia"), "titulo" => $req->getParam("titulo"),
            "autor" => $req->getParam("autor"), "descripcion" => $req->getParam("descripcion"), "precio" => $req->getParam("precio"),
            "email" => $req->getParam("email")
        );
        print json_encode(crearLibro($datos));
    } else {
        session_destroy();
        print json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// f)
$app->put("/actualizarPortada/{referencia}", function ($req) {
    $api_key = $req->getParam("api_session");
    session_id($api_key);
    session_start();
    if (isset($_SESSION["lector"])) {
        $referencia = $req->getAttribute("referencia");
        $portada = $req->getParam("portada");
        print json_encode(actualizarPortada($referencia, $portada));
    } else {
        session_destroy();
        print json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// g)
$app->get("/repetido/{tabla}/{columna}/{valor}", function ($req) {
    $tabla = $req->getAttribute("tabla");
    $columna = $req->getAttribute("columna");
    $valor = $req->getAttribute("valor");
    print json_encode(comprobarRepetido($tabla, $columna, $valor));
});

// Una vez creado servicios los pongo a disposición
$app->run();
