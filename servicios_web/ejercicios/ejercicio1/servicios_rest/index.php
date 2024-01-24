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

$app->put("/producto/actualizar/{cod}", function ($req) {
    $datos = array($req->getParam("nombre"), $req->getParam("nombre_corto"), $req->getParam("descripcion"), $req->getParam("PVP"), $req->getParam("familia"), $req->getAttribute("cod"));
    print json_encode(actualizarProducto($datos));
});

$app->delete("/producto/borrar/{id}", function ($req) {
    print json_encode(borrarProducto($req->getAttribute("id")));
});

$app->get("/familias", function () {
    print json_encode(getAllFamilias());
});

$app->get("/repetido/{tabla}/{columna}/{valor}", function ($req) {
    $tabla = $req->getAttribute("tabla");
    $col = $req->getAttribute("columna");
    $valor = $req->getAttribute("valor");
    print json_encode(buscar_repetido($tabla, $col, $valor));
});

$app->get("/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}", function ($req) {
    $tabla = $req->getAttribute("tabla");
    $col = $req->getAttribute("columna");
    $valor = $req->getAttribute("valor");
    $col_id = $req->getAttribute("columna_id");
    $valor_id = $req->getAttribute("valor_id");
    print json_encode(buscar_valor_repetido($tabla, $col, $valor, $col_id, $valor_id));
});

// Una vez creado servicios los pongo a disposición
$app->run();
