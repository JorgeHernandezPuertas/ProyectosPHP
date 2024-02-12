<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


// Una vez creado servicios los pongo a disposición
$app->run();
