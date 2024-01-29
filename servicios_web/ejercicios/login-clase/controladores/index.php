<?php
require "../modelos/modelo.php";

require __DIR__ . '/servicios_rest/Slim/autoload.php';

$app = new Slim\App;

$app->post("/login", function ($req) {
  $usuario = $req->getParam("usuario");
  $clave = $req->getParam("clave");

  print json_encode(login($usuario, $clave));
});



$app->run();
