<?php
define("DIR_SERV", "http://localhost/Proyectos/master-class/servicios_rest");
define("MINUTOS", 10);
$DIAS[1] = "Lunes";
$DIAS[] = "Martes";
$DIAS[] = "Miércoles";
$DIAS[] = "Jueves";
$DIAS[] = "Viernes";
define("DIAS", $DIAS);
$HORAS[1] = "8:15 - 9:15";
$HORAS[] = "9:15 - 10:15";
$HORAS[] = "10:15 - 11:15";
$HORAS[] = "11:15 - 11:45";
$HORAS[] = "11:45 - 12:45";
$HORAS[] = "12:45 - 13:45";
$HORAS[] = "13:45 - 14:45";
define("HORAS", $HORAS);


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
    $page = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>' . $body . '</body>
    </html>';
    return $page;
}
