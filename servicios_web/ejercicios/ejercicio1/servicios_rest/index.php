<?php
// URL: http://localhost/Proyectos/servicios_web/ejercicios/ejercicio1/servicios_rest
require __DIR__ . '/Slim/autoload.php';
require '../modelo_php/modelo.php';

$app = new \Slim\App;


$app->get('/productos', function () {
    print json_encode(getAll());
});

$app->get('/productos/{id}', function ($req) {
    $id = $req->getAttribute("id");
    print json_encode(getProductoById($id));
});

$app->post("/producto/insertar", function ($req) {
    $datos = array($req->getParam("cod"), $req->getParam("nombre"), $req->getParam("nombre_corto"), $req->getParam("descripcion"), $req->getParam("PVP"), $req->getParam("familia"));
    print json_encode(insertarProducto($datos));
});

// Una vez creado servicios los pongo a disposición
$app->run();
