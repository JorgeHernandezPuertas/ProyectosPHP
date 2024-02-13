<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página inicio</title>
  <style>
    img {
      width: 100%;
      height: auto;
    }

    .enlace {
      color: blue;
      text-decoration: underline;
      background-color: inherit;
      border: none;
      cursor: pointer;
    }

    table {
      border-collapse: collapse;
      text-align: center;
      width: 60%;
      margin: 3rem auto;
    }

    td,
    th,
    tr {
      border: 1px solid black;
      padding: .25rem;
    }

    th {
      background-color: #ccc;
    }
  </style>
</head>

<body>
  <h1>Librería</h1>
  <form method="post" action="index.php">
    Bienvenido <?php print $datos_usuario_log->usuario ?> -
    <button class="enlace" name="btnSalir">
      Salir
    </button>
  </form>
  <?php
  // Obtengo los datos del horario de ese profesor
  $url = DIR_SERV . "/obtenerHorario/" . $datos_usuario_log->id_usuario;
  $datos = array("api_session" => $_SESSION["api_session"]);
  $obj = json_decode(consumir_servicios_REST($url, "get", $datos));
  if (!$obj) {
    die("<p>Error consumiendo el servicio en la url: $url</p></body></html>");
  } else if (isset($obj->error)) {
    die("<p>Error consumiendo el servicio: $obj->error</p></body></html>");
  }

  $horario = $obj->horario;

  // Creo la tabla de este usuario
  $dias = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes");
  $horas = array("8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45", "12:45 - 13:45", "13:45 - 14:45");
  print "<table>";
  // Hago la cabecera
  print "<tr>";
  print "<th></th>";
  for ($i = 0; $i < count($dias); $i++) {
    print "<th>" . $dias[$i] . "</th>";
  }
  print "</tr>";
  // Completo la tabla
  for ($i = 0; $i < count($horas); $i++) {
    print "<tr>";
    print "<th>" . $horas[$i] . "</th>";
    if ($i === 3) {
      print "<td colspan='5'>Recreo</td>";
    } else {
      for ($j = 0; $j < count($dias); $j++) {
        $clases = obtenerClases($i + 1, $j + 1, $horario);
        print "<td>$clases</td>";
      }
    }
  }
  print "</tr>";
  print "</table>";
  ?>

</body>

</html>