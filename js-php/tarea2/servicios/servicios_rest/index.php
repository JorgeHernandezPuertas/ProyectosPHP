<?php
// URL: http://localhost/Proyectos/servicios_web/ejercicios/ejercicio1/servicios_rest
require __DIR__ . '/Slim/autoload.php';
require '../modelo_php/modelo.php';

$app = new \Slim\App;

$app->post('/salir', function ($request) {
    session_id($request->getParam('api_session'));
    session_start();
    session_destroy();
    echo json_encode(array("logout" => "Close sesion"));
});

$app->post('/login', function ($request) {
    $usuario = $request->getParam('usuario');
    $clave = $request->getParam('clave');

    echo json_encode(login($usuario, $clave));
});


$app->get('/logueado', function ($request) {
    $api_key = $request->getParam("api_session");
    session_id($api_key);
    session_start();
    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->get('/productos', function ($req) {
    $api_key = $req->getParam("api_session");
    session_id($api_key);
    session_start();
    if (isset($_SESSION["usuario"])) {
        print json_encode(getAll());
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->get('/productos/{id}', function ($req) {
    $api_key = $req->getParam("api_session");
    session_id($api_key);
    session_start();
    if (isset($_SESSION["usuario"])) {
        $id = $req->getAttribute("id");
        print json_encode(getProductoById($id));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->post("/producto/insertar", function ($req) {
    $api_key = $req->getParam("api_session");
    session_id($api_key);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] === "admin") {
        $datos = array($req->getParam("cod"), $req->getParam("nombre"), $req->getParam("nombre_corto"), $req->getParam("descripcion"), $req->getParam("PVP"), $req->getParam("familia"));
        print json_encode(insertarProducto($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->put("/producto/actualizar/{cod}", function ($req) {
    $api_key = $req->getParam("api_session");
    session_id($api_key);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] === "admin") {
        $datos = array($req->getParam("nombre"), $req->getParam("nombre_corto"), $req->getParam("descripcion"), $req->getParam("PVP"), $req->getParam("familia"), $req->getAttribute("cod"));
        print json_encode(actualizarProducto($datos));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->delete("/producto/borrar/{id}", function ($req) {
    $api_key = $req->getParam("api_session");
    session_id($api_key);
    session_start();
    if (isset($_SESSION["usuario"]) && $_SESSION["tipo"] === "admin") {
        print json_encode(borrarProducto($req->getAttribute("id")));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->get("/familias", function ($req) {
    $api_key = $req->getParam("api_session");
    session_id($api_key);
    session_start();
    if (isset($_SESSION["usuario"])) {
        print json_encode(getAllFamilias());
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->get("/familia/{cod}", function ($req) {
    $api_key = $req->getParam("api_session");
    session_id($api_key);
    session_start();
    if (isset($_SESSION["usuario"])) {
        $cod = $req->getAttribute("cod");
        print json_encode(getFamilia($cod));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->get("/repetido/{tabla}/{columna}/{valor}", function ($req) {
    $api_key = $req->getParam("api_session");
    session_id($api_key);
    session_start();
    if (isset($_SESSION["usuario"])) {
        $tabla = $req->getAttribute("tabla");
        $col = $req->getAttribute("columna");
        $valor = $req->getAttribute("valor");
        print json_encode(buscar_repetido($tabla, $col, $valor));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

$app->get("/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}", function ($req) {
    $api_key = $req->getParam("api_session");
    session_id($api_key);
    session_start();
    if (isset($_SESSION["usuario"])) {
        $tabla = $req->getAttribute("tabla");
        $col = $req->getAttribute("columna");
        $valor = $req->getAttribute("valor");
        $col_id = $req->getAttribute("columna_id");
        $valor_id = $req->getAttribute("valor_id");
        print json_encode(buscar_valor_repetido($tabla, $col, $valor, $col_id, $valor_id));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
    }
});

// Una vez creado servicios los pongo a disposición
$app->run();
