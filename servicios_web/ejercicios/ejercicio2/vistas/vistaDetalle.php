<?php
$url = DIR_SERV . "/productos/" . $_POST["btnDetalle"];
$respuesta = consumir_servicios_REST($url, "get");
$obj = json_decode($respuesta);
if (!$obj) {
  die("<p>Ha ocurrido un error recuperando los productos por parte del servicio: $url</p></body></html>");
} else if (isset($obj->mensaje_error)) {
  die("<p>Ha ocurrido un error recuperando los productos por parte del servicio: $url <br/> Error: " . $obj->mensaje_error . "</p></body></html>");
}

?>
<div>
  <h3>Detalles del producto con código <?php print $_POST["btnDetalle"] ?></h3>
  <p><strong>Nombre:</strong> <?php print $obj->producto->nombre ?></p>
  <p><strong>Nombre corto:</strong> <?php print $obj->producto->nombre_corto ?></p>
  <p><strong>Descripción:</strong> <?php print $obj->producto->descripcion ?></p>
  <p><strong>PVP:</strong> <?php print $obj->producto->PVP ?></p>
  <p><strong>Familia:</strong> <?php print $obj->producto->familia ?></p>
</div>