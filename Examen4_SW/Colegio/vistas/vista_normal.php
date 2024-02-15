<?php
$url = DIR_SERV . "/notasAlumno/" . $datos_usuario_log->cod_usu;
$datos = array("api_session" => $_SESSION["api_session"]);
$obj = json_decode(consumir_servicios_REST($url, "get", $datos));
if (!$obj) {
  session_destroy();
  die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
}
if (isset($obj->error)) {
  session_destroy();
  die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $obj->error . "</p>"));
}

$notas = $obj->notas;
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Examen4 DWESE Curso 23-24</title>
  <style>
    .enlace {
      color: blue;
      background-color: inherit;
      cursor: pointer;
      text-decoration: underline;
      border: none;
    }

    table {
      text-align: center;
      border-collapse: collapse;
    }

    th {
      background-color: lightgrey;
    }

    td,
    th,
    tr {
      border: 1px solid black;
      padding: .25rem;
    }
  </style>
</head>

<body>
  <h2>Notas de los alumnos</h2>
  <form action="index.php" method="post">
    Bienvenido <strong><?php print $datos_usuario_log->usuario ?></strong> -
    <button class="enlace" name="btnSalir">Salir</button>
  </form>
  <h3>Notas del Alumno <?php print $datos_usuario_log->nombre ?></h3>
  <?php
  print "<table>";
  print "<tr><th>Asignatura</th><th>Nota</th></tr>";
  foreach ($notas as $tupla) {
    print "<tr>";
    print "<td>$tupla->denominacion</td>";
    print "<td>$tupla->nota</td>";
    print "</tr>";
  }
  print "</table>";
  ?>
</body>

</html>