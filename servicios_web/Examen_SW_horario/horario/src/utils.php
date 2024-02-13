<?php
define("DIR_SERV", "http://localhost/Proyectos/servicios_web/Examen_SW_horario/servicios_rest");
define("MINUTOS", 10);


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
  $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
  $html .= '<title>' . $title . '</title></head>';
  $html .= '<body>' . $body . '</body></html>';
  return $html;
}

function comprobarRepetido($tabla, $columna, $valor)
{
  $url = DIR_SERV . "/repetido/" . urlencode($tabla) . "/" . urlencode($columna) . "/" . urlencode($valor);
  $obj = json_decode(consumir_servicios_REST($url, "get"));
  if (!$obj) {
    die(error_page("Libreria", "<h2>Error consumiendo el servicio web</h2>"));
  } else if (isset($obj->error)) {
    die(error_page("Libreria", "<h2>Error consumiendo el servicio web</h2><p>$obj->error</p>"));
  }

  return $obj->repetido;
}

function obtenerClases($hora, $dia, $horario)
{
  $clases = "";
  foreach ($horario as $indice => $tupla) {
    if ($tupla->dia === $dia && $tupla->hora === $hora) {
      $clases .= $tupla->nombre . "/";
    }
  }
  $clases = substr($clases, 0, strlen($clases) - 1);
  return $clases;
}
