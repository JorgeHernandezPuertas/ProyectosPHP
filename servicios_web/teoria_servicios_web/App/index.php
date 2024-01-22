<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teoría servicios web</title>
</head>

<body>
  <?php
  // Creo como constante la dirección de la API
  define('DIR_SERV', "http://localhost/Proyectos/teoria_servicios_web/primera_api");

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

  $url = DIR_SERV . "/saludo/" . urlencode("Dario Rico");
  $respuesta = consumir_servicios_REST($url, "get");
  $obj = json_decode($respuesta);
  if (!$obj) {
    die("<p>Error consumiendo el servicio web: $url</p>" . $respuesta);
  }

  print "<p>El saludo recibido ha sido <strong>" . $obj->mensaje . "</strong></p>";

  $url = DIR_SERV . "/saludo";
  $respuesta = consumir_servicios_REST($url, "post", array("nombre" => "dario"));
  $obj = json_decode($respuesta);
  if (!$obj) {
    die("<p>Error consumiendo el servicio web: $url</p>" . $respuesta);
  }

  print "<p>El saludo enviado ha sido <strong> " . $obj->mensaje . " </strong></p>";

  $respuesta = consumir_servicios_REST($url, "delete", array("id" => "5"));
  $obj = json_decode($respuesta);
  if (!$obj) {
    die("<p>Error consumiendo el servicio web: $url</p>" . $respuesta);
  }

  print "<p>" . $obj->mensaje . "</p>";

  $url = DIR_SERV . "/actualizar_saludo/76";
  $respuesta = consumir_servicios_REST($url, "put", array("nombre" => "pepe"));
  $obj = json_decode($respuesta);
  if (!$obj) {
    die("<p>Error consumiendo el servicio web: $url</p>" . $respuesta);
  }

  print "<p>" . $obj->mensaje . "</p>";

  ?>
</body>

</html>