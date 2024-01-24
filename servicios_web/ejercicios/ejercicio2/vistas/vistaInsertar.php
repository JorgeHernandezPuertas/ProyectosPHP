<?php
$url = DIR_SERV . "/familias";
$respuesta = consumir_servicios_REST($url, "get");
$obj = json_decode($respuesta);
if (!$obj) die("<p>Ha ocurrido un error recuperando las familias por parte del servicio: $url</p></body></html>");
if (isset($obj->mensaje_error)) die("<p>Ha ocurrido un error recuperando los productos por parte del servicio: $url <br/> Error: " . $obj->mensaje_error . "</p></body></html>");

print "<div><form action='index.php' method='post' >";
print "<h3>Creando un Producto</h3>";
print "<p>";
print "<label for='cod'>Código: </label>";
print "<input name='cod' id='cod' type='text' />";
print "</p>";
print "<p>";
print "<label for='nom'>Nombre: </label>";
print "<input name='nom' id='nom' type='text' />";
print "</p>";
print "<p>";
print "<label for='nomCor'>Nombre corto: </label>";
print "<input name='nomCor' id='nomCor' type='text' />";
print "</p>";
print "<p>";
print "<label for='desc'>Descripcion: </label>";
print "<textarea name='desc' id='desc'></textarea>";
print "</p>";
print "<p>";
print "<label for='pvp'>PVP: </label>";
print "<input name='pvp' id='pvp' type='text' />";
print "</p>";
print "<p>";
print "<label for='fam'>Seleccione una familia: </label>";
print "<select name='name' id='name'>";
foreach ($obj->familias as $tupla) {
  print "<option value='" . $tupla->cod . "'>" . $tupla->nombre . "</option>";
}
print "</select>";
print "</p>";
print "<button name='btnVolver'>Volver</button> <button name='btnContInsertar'>Continuar</button>";
print "</form></div>";
