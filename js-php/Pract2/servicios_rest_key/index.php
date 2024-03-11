<?php
require "src/funciones_ctes.php";

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->post('/salir',function($request){

    session_id($request->getParam('api_session'));
    session_start();
    session_destroy();
    echo json_encode(array("logout"=>"Close sesion"));
    
});

$app->post('/login',function($request){

    $usuario=$request->getParam('usuario');    
    $clave=$request->getParam('clave');

    echo json_encode(login($usuario,$clave));
});


$app->get('/logueado',function($request){

    $api_key=$request->getParam("api_session");
    session_id($api_key);
    session_start();
    if(isset($_SESSION["usuario"]))
    {
        echo json_encode(logueado($_SESSION["usuario"],$_SESSION["clave"]));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }

});


$app->get('/productos',function($request){
    $api_key=$request->getParam("api_session");
    session_id($api_key);
    session_start();
    if(isset($_SESSION["usuario"]))
    {
        echo json_encode(obtener_productos());
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }

});

$app->get('/producto/{cod}',function($request){
    $api_key=$request->getParam("api_session");
    session_id($api_key);
    session_start();
    if(isset($_SESSION["usuario"]))
    {
        echo json_encode(obtener_producto($request->getAttribute('cod')));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
});


$app->post('/producto/insertar',function($request){
    $api_key=$request->getParam("api_session");
    session_id($api_key);
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        $datos[]=$request->getParam("cod");
        $datos[]=$request->getParam("nombre");
        $datos[]=$request->getParam("nombre_corto");
        $datos[]=$request->getParam("descripcion");
        $datos[]=$request->getParam("PVP");
        $datos[]=$request->getParam("familia");

        echo json_encode(insertar_producto($datos));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }
});

$app->put('/producto/actualizar/{cod}',function($request){
    $api_key=$request->getParam("api_session");
    session_id($api_key);
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        $datos[]=$request->getParam("nombre");
        $datos[]=$request->getParam("nombre_corto");
        $datos[]=$request->getParam("descripcion");
        $datos[]=$request->getParam("PVP");
        $datos[]=$request->getParam("familia");
        $datos[]=$request->getAttribute("cod");
    
        echo json_encode(actualizar_producto($datos));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }    
});

$app->delete('/producto/borrar/{cod}',function($request){
    $api_key=$request->getParam("api_session");
    session_id($api_key);
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        echo json_encode(borrar_producto($request->getAttribute("cod")));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    }    
});

$app->get('/familias',function($request){
    $api_key=$request->getParam("api_session");
    session_id($api_key);
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        echo json_encode(obtener_familias());
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    } 
});

$app->get('/familia/{cod}',function($request){
    $api_key=$request->getParam("api_session");
    session_id($api_key);
    session_start();
    if(isset($_SESSION["usuario"]))
    {
        echo json_encode(obtener_familia($request->getAttribute('cod')));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    } 
});

$app->get('/repetido/{tabla}/{columna}/{valor}',function($request){
    $api_key=$request->getParam("api_session");
    session_id($api_key);
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        echo json_encode(repetido($request->getAttribute('tabla'),$request->getAttribute('columna'),$request->getAttribute('valor')));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    } 
});

$app->get('/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}',function($request){
    $api_key=$request->getParam("api_session");
    session_id($api_key);
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="admin")
    {
        echo json_encode(repetido($request->getAttribute('tabla'),$request->getAttribute('columna'),$request->getAttribute('valor'),$request->getAttribute('columna_id'),$request->getAttribute('valor_id')));
    }
    else
    {
        session_destroy();
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
    } 
});

$app->run();

?>