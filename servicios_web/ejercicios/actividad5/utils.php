<?php
define("DIR_SERV", "http://localhost/Proyectos/servicios_web/ejercicios/Ejercicio3-tokens/login_restful");
define("MINUTOS", 3);

function consumir_servicios_REST($url, $metodo, $datos = null)
{
    $llamada = curl_init();
    curl_setopt($llamada, CURLOPT_URL, $url);
    curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
    if (isset($datos))
        curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
    $respuesta = curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}
function error_page($title, $body)
{

    $page = '
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>' . $title . '</title>
</head>

<body>' . $body . '</body>

</html>';
    return $page;
}

function comprobarCodRepetido($cod, $api_key)
{
    $url = DIR_SERV . "/repetido/producto/cod/" . $cod;
    $respuesta = consumir_servicios_REST($url, "get", array("api_key" => $api_key));
    $obj = json_decode($respuesta);
    if (!$obj) die(error_page("Error en el servicio", "<p>Ha ocurrido un error comprobando si se repite el cod por parte del servicio: $url</p>"));
    if (isset($obj->mensaje_error)) die(error_page("Error en el servicio", "<p>Ha ocurrido un error comprobando si se repite el cod por parte del servicio: $url</p>"));
    return $obj->repetido;
}

function comprobarRepetido($tabla, $col, $valor, $col_cod = null, $val_cod = null, $api_key)
{
    if ($col_cod) {
        $url = DIR_SERV . "/repetido/$tabla/$col/" . urlencode($valor) . "/$col_cod/" . urlencode($val_cod);
    } else {
        $url = DIR_SERV . "/repetido/$tabla/$col/" . urlencode($valor);
    }

    $respuesta = consumir_servicios_REST($url, "get", array("api_key" => $api_key));
    $obj = json_decode($respuesta);
    if (!$obj) die(error_page("Error en el servicio", "<p>Ha ocurrido un error comprobando si se repite el cod por parte del servicio: $url</p>"));
    if (isset($obj->mensaje_error)) die(error_page("Error en el servicio", "<p>Ha ocurrido un error comprobando si se repite el cod por parte del servicio: $url</p>"));
    return $obj->repetido;
}
