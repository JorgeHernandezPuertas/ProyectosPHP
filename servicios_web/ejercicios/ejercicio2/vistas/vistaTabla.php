<?php
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
print "<tr><th>COD</th><th>Nombre</th><th>PVP</th><th><form method='post' action='index.php' ><button name='btnInsertar' class='enlace' >Producto+</button></form></th></tr>";
foreach ($obj->productos as $tupla) {
  print "<tr><form method='post' action='index.php'><td><button name='btnDetalle' class='enlace' value='" . $tupla->cod . "'>" . $tupla->cod . "</button></td><td>" . $tupla->nombre_corto . "</td><td>" . $tupla->PVP . "</td><td><button name='btnBorrar' value='" . $tupla->cod . "' class='enlace'>Borrar</button> - <button name='btnEditar' value='" . $tupla->cod . "' class='enlace'>Editar</button></td></form></tr>";
}
print "</table>";
