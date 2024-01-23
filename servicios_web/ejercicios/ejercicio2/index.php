<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD Tienda - Actividad 2</title>
</head>

<body>
  <h2>Productos</h2>
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
  // Recupero todos los productos
  $url = DIR_SERV . "/productos";
  $respuesta = consumir_servicios_REST($url, "get");
  $obj = json_decode($respuesta);
  if (!$obj) {
    die("<p>Ha ocurrido un error recuperando los productos por parte del servicio: $url</p></body></html>");
  } else if (isset($obj->mensaje_error)) {
    die("<p>Ha ocurrido un error recuperando los productos por parte del servicio: $url <br/> Error: " . $obj->mensaje_error . "</p></body></html>");
  }

  print "<table>";
  print "<tr></tr>";
  print "</table>";
  ?>

</body>

</html>