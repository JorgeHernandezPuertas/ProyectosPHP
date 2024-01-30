<?php
// URL: http://localhost/Proyectos/servicios_web/ejercicios/actividad3/login_restful
require __DIR__ . '/Slim/autoload.php';
require '../modelos/modelo.php';

$app = new \Slim\App;


$app->get('/usuarios', function () {
    print json_encode(getAllUsers());
});

$app->get('/usuario/{id_usuario}', function ($req) {
    $id = $req->getAttribute("id_usuario");
    print json_encode(getUser($id));
});

$app->post("/crearUsuario", function ($req) {
    // nombre, usuario, clave, email
    $datos = array($req->getParam("nombre"), $req->getParam("usuario"), $req->getParam("clave"), $req->getParam("email"));
    print json_encode(insertUser($datos));
});

$app->post("/login", function ($req) {
    $datos = array($req->getParam("usuario"), $req->getParam("clave"));
    print json_encode(checkLogin($datos));
});

$app->put("/actualizarUsuario/{idUsuario}", function ($req) {
    $datos = array($req->getParam("nombre"), $req->getParam("usuario"), $req->getParam("clave"), $req->getParam("email"), $req->getAttribute("idUsuario"));
    print json_encode(updateUser($datos));
});

$app->delete("/borrarUsuario/{idUsuario}", function ($req) {
    print json_encode(deleteUser($req->getAttribute("idUsuario")));
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
