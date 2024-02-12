<h2>Listado de los Libros</h2>

<div class="libros">
  <?php
  $url = DIR_SERV . "/obtenerLibros";
  $obj = json_decode(consumir_servicios_REST($url, "get"));
  if (!$obj) {
    die("Error consumiendo el servicio web</body></html>");
  } else if (isset($obj->error)) {
    die("Error consumiendo el servicio web : $obj->error</body></html>");
  }

  foreach ($obj->libros as $tupla) {
    print "<div>";
    print "<img title='$tupla->titulo' src='images/$tupla->portada' alt='$tupla->titulo' >";
    print "<p>$tupla->titulo - $tupla->precio €</p>";
    print "</div>";
  }

  ?>
</div>