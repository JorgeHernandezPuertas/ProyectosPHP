<?php
// URL: http://localhost/Proyectos/teoria_servicios_web/primera_api
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

$app->get('/saludo', function () {
    print json_encode(array('mensaje' => 'Hola'));
});

$app->get('/saludo/{nombre}', function ($request) {
    $valor_recibido = $request->getAttribute("nombre");
    print json_encode(array('mensaje' => 'Hola ' . $valor_recibido));
});

// $app->post();
$app->post("/saludo", function ($request) {
    $valor_recibido = $request->getParam('nombre');
    print json_encode(array("mensaje" => $valor_recibido));
});

// $app->delete();
$app->delete("/saludo", function ($request) {
    $valor_recibido = $request->getParam('id');
    print json_encode(array("mensaje" => "Se ha borrado el saludo con id $valor_recibido con éxito"));
});

// $app->put();
$app->put("/actualizar_saludo/{id}", function ($request) {
    $id_recibida = $request->getAttribute("id");
    $nombre_nuevo = $request->getParam("nombre");
    print json_encode(array("mensaje" => "Se ha actualizado el saludo con id: $id_recibida y el nuevo nombre es: $nombre_nuevo"));
});

// Una vez creado servicios los pongo a disposición
$app->run();
