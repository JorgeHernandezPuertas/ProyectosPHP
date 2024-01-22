<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>API tienda - Actividad 1</title>
</head>


<body>
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
  $datos = array("cod" => "YYYYYZY", "nombre" => "producto a borrar", "nombre_corto" => "producto a borrar", "descripcion" => "descripcion a borrar", "PVP" => 25.5, "familia" => "MP3");
  $url = DIR_SERV . "/producto/insertar";

  $respuesta = consumir_servicios_REST($url, "post", $datos);
  $obj = json_decode($respuesta);
  if ($obj) {
    die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
  }
  if (isset($obj->mensaje_error)) {
    die("<p>Error consumiendo el servicio: " . $url . "</p>" . $obj->mensaje_error);
  }
  print "<p>El json de respuesta al insertar es: <br/> $respuesta</p>"
  ?>
  <h2>Página inicial de la API</h2>
  <p>Para usar la API de la tienda usa la URL: 'http://localhost/Proyectos/servicios_web/ejercicios/ejercicio1/servicios_rest'</p>
  <p>'/productos' -> devuelve todos los productos</p>

  <p>'/producto/{codigo}' -> devuelve el producto con ese código</p>
  <p>'/producto/insertar' -> Formulario para insertar el producto</p>


</body>

</html>