<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>API tienda - Actividad 1</title>
</head>


<body>
  <h2>Página inicial de la API</h2>
  <p>Para usar la API de la tienda usa la URL: 'http://localhost/Proyectos/servicios_web/ejercicios/ejercicio1/servicios_rest'</p>
  <?php
  define("DIR_SERV", "http://localhost/Proyectos/servicios_web/ejercicios/ejercicio1/servicios_rest");

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
  // $datos = array("cod" => "YYYYYYY", "nombre" => "producto a borrar", "nombre_corto" => "producto a borrar", "descripcion" => "descripcion a borrar", "PVP" => 25.5, "familia" => "MP3");
  $url = DIR_SERV . "/productos";

  $respuesta = consumir_servicios_REST($url, "get");
  $obj = json_decode($respuesta);
  if (!$obj) {
    die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
  }
  if (isset($obj->mensaje_error)) {
    die("<p>Error consumiendo el servicio: " . $url . "</p>" . $obj->mensaje_error);
  }

  print "<table>";
  print "<tr><th>Cod</th><th>Nombre Corto</th></tr>";
  foreach ($obj->productos as $tupla) {
    print "<tr><td>" . $tupla->cod . "</td><td>" . $tupla->nombre_corto . "</td></tr>";
  }
  print "</table>";

  $url = DIR_SERV . "/productos/3DSNG";

  $respuesta = consumir_servicios_REST($url, "get");

  $obj = json_decode($respuesta);
  if (!$obj) {
    die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
  }
  if (isset($obj->mensaje_error)) {
    die("<p>Error consumiendo el servicio: " . $url . "</p>" . $obj->mensaje_error);
  }

  print "<h2>Objeto recuperado en soltiario</h2>";
  print "<p>cod: " . $obj->producto->cod . " ; nombre_corto: " . $obj->producto->nombre_corto . "</p>";
  ?>
</body>

</html>