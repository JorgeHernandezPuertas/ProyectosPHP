<?php
// Obtengo los profesores del select antes de cargar, porque en caso de error le quiero redirigir
$url = DIR_SERV . "/obtenerProfesores";
$datos = array("api_session" => $_SESSION["api_session"]);
$obj = json_decode(consumir_servicios_REST($url, "get", $datos));
if (!$obj) {
  session_destroy();
  die(error_page("Error consumiendo el servicio", "<p>En la url: $url</p>"));
} else if (isset($obj->error)) {
  session_destroy();
  die(error_page("Error consumiendo el servicio", "<p>Error: $obj->error</p>"));
} else if (isset($obj->no_auth)) {
  session_unset();
  $_SESSION["seguridad"] = "La sesión de la API ha caducado.";
  header("Location: index.php");
  exit;
}

if (isset($_POST["btnHorario"]) || isset($_POST["btnEditar"])) {
  $id_prof = isset($_POST["btnHorario"]) ? $_POST["profesor"] : $_POST["btnEditar"];
  $url = DIR_SERV . "/obtenerHorario/" . $id_prof;
  $datos = array("api_session" => $_SESSION["api_session"]);
  $obj2 = json_decode(consumir_servicios_REST($url, "get", $datos));
  if (!$obj2) {
    session_destroy();
    die(error_page("Error consumiendo el servicio", "<p>En la url: $url</p>"));
  } else if (isset($obj2->error)) {
    session_destroy();
    die(error_page("Error consumiendo el servicio", "<p>Error: $obj->error</p>"));
  } else if (isset($obj2->no_auth)) {
    session_unset();
    $_SESSION["seguridad"] = "La sesión de la API ha caducado.";
    header("Location: index.php");
    exit;
  }
  $horario = $obj2->horario;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Práctica examen 2</title>
  <style>
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

    .enlace {
      color: blue;
      text-decoration: underline;
      background-color: inherit;
      border: none;
      cursor: pointer;
    }

    .center {
      text-align: center;
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
  <h2>Horario de los Profesores</h2>
  <?php


  print "<form method='post' action='index.php' >";
  print "Horario de los profesores: ";
  print "<select name='profesor'>";
  foreach ($obj->profesores as $tupla) {
    if ((isset($_POST["profesor"]) || isset($_POST["btnEditar"])) && $id_prof == $tupla->id_usuario) {
      $option = "<option value='$tupla->id_usuario' selected>$tupla->nombre</option>";
      $nombre_actual = $tupla->nombre;
    } else {
      $option = "<option value='$tupla->id_usuario'>$tupla->nombre</option>";
    }
    print $option;
  }
  print "</select>";
  print " <button name='btnHorario'>Ver horario</button>";
  print "</form>";

  if (isset($_POST["btnHorario"]) || isset($_POST["btnEditar"])) {
    print "<h2 class='center'>Horario de <i>$nombre_actual</i></h2>";
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
          $boton = "<form method='post' action='index.php'><input type='hidden' name='hora' value='$i' /><input type='hidden' name='dia' value='$j' /><button class='enlace' name='btnEditar' value='" . $id_prof . "' >Editar</button></form>";
          $clases = obtenerClases($i + 1, $j + 1, $horario);
          print "<td>$boton<br/>$clases</td>";
        }
      }
    }
    print "</tr>";
    print "</table>";

    if (isset($_POST["btnEditar"])) {
      print "<h2>Editando la " . ($_POST["hora"] + 1) . "º hora (" . $horas[$_POST["hora"]] . ") del " . $dias[$_POST["dia"]] . "</h2>";
      
    }
  }
  ?>


</body>

</html>