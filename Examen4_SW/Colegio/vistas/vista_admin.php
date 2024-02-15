<?php
$url = DIR_SERV . "/alumnos";
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
$alumnos = $obj->alumnos;

if (isset($_SESSION["alumno"])) {
  $_POST["alumno"] = $_SESSION["alumno"];
  unset($_SESSION["alumno"]);
}

if (isset($_POST["alumno"])) {
  if (isset($_POST["btnBorrar"])) {
    // Borro la nota
    $url = DIR_SERV . "/quitarNota/" . $_POST["alumno"];
    $datos = array("api_session" => $_SESSION["api_session"], "cod_asig" => $_POST["btnBorrar"]);
    $obj4 = json_decode(consumir_servicios_REST($url, "delete", $datos));
    if (!$obj4) {
      session_destroy();
      die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
    }
    if (isset($obj4->error)) {
      session_destroy();
      die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $obj4->error . "</p>"));
    }

    $_SESSION["mensaje"] = $obj4->mensaje;
    $_SESSION["alumno"] = $_POST["alumno"];
    header("Location: index.php");
    exit;
  }

  if (isset($_POST["btnCambiar"])) {
    $error_nota = $_POST["nota"] === "" || !is_numeric($_POST["nota"]) || $_POST["nota"] < 0 || $_POST["nota"] > 10;
    if (!$error_nota) {
      // Cambio la nota
      $url = DIR_SERV . "/cambiarNota/" . $_POST["alumno"];
      $datos = array("api_session" => $_SESSION["api_session"], "cod_asig" => $_POST["btnCambiar"], "nota" => $_POST["nota"]);
      $obj5 = json_decode(consumir_servicios_REST($url, "put", $datos));
      if (!$obj5) {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
      }
      if (isset($obj5->error)) {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $obj5->error . "</p>"));
      }

      $_SESSION["mensaje"] = "Nota cambiada con éxito";
      $_SESSION["alumno"] = $_POST["alumno"];
      header("Location: index.php");
      exit;
    }
  }

  if (isset($_POST["asignatura"])) {
    // Califico la asignatura
    $url = DIR_SERV . "/ponerNota/" . $_POST["alumno"];
    $datos = array("api_session" => $_SESSION["api_session"], "cod_asig" => $_POST["asignatura"]);
    $obj6 = json_decode(consumir_servicios_REST($url, "post", $datos));
    if (!$obj6) {
      session_destroy();
      die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
    }
    if (isset($obj6->error)) {
      session_destroy();
      die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $obj6->error . "</p>"));
    }

    $_SESSION["mensaje"] = "Asignatura calificada con un 0. Cambie la nota si lo estima necesario";
    $_SESSION["alumno"] = $_POST["alumno"];
    header("Location: index.php");
    exit;
  }

  // Notas del alumno
  $url = DIR_SERV . "/notasAlumno/" . $_POST["alumno"];
  $datos = array("api_session" => $_SESSION["api_session"]);
  $obj2 = json_decode(consumir_servicios_REST($url, "get", $datos));
  if (!$obj2) {
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
  }
  if (isset($obj2->error)) {
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $obj2->error . "</p>"));
  }

  $notas = $obj2->notas;

  // Asignaturas por calificar
  $url = DIR_SERV . "/NotasNoEvalAlumno/" . $_POST["alumno"];
  $datos = array("api_session" => $_SESSION["api_session"]);
  $obj3 = json_decode(consumir_servicios_REST($url, "get", $datos));
  if (!$obj3) {
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
  }
  if (isset($obj3->error)) {
    session_destroy();
    die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $obj3->error . "</p>"));
  }

  $asignaturas_no_eval = $obj3->notas;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Examen4 DWESE Curso 23-24</title>
  <style>
    .error {
      color: red;
    }

    .enlace {
      color: blue;
      background-color: inherit;
      cursor: pointer;
      text-decoration: underline;
      border: none;
    }

    .mensaje {
      color: blue;
    }

    .mod {
      border-color: orange;
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
  <?php
  if (count($alumnos) === 0) {
    print "<p>En estos momentos no tenemos ningún alumno registrado en la BD</p>";
  } else {
    print "<p><form method='post' action='.'>";
    print "Seleccione un Alumno: ";
    print "<select name='alumno'>";
    foreach ($alumnos as $tupla) {
      if (isset($_POST["alumno"]) && $_POST["alumno"] == $tupla->cod_usu) {
        $alumno_sel = $tupla;
        print "<option value='$tupla->cod_usu' selected>$tupla->nombre</option>";
      } else {
        print "<option value='$tupla->cod_usu'>$tupla->nombre</option>";
      }
    }
    print "</select>";
    print " <button name='btnVerNotas'>Ver Notas</button>";
    print "</form></p>";
  }

  if (isset($_POST["alumno"])) {
    print "<h2>Notas del Alumno $alumno_sel->nombre</h2>";

    print "<table>";
    print "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
    foreach ($notas as $tupla) {
      print "<form method='post' action='.'>";
      print "<tr>";
      print "<td>$tupla->denominacion</td>";
      $botones = "<input type='hidden' name='alumno' value='" . $_POST["alumno"] . "' />";

      if (((isset($_POST["btnEditar"]) && $tupla->cod_asig == $_POST["btnEditar"]) || (isset($_POST["btnCambiar"]) && $_POST["btnCambiar"] == $tupla->cod_asig)) || (isset($_POST["asignatura"]) && $_POST["asignatura"] == $tupla->cod_asig)) {
        $input = "<input class='mod' name='nota' type='text' value='$tupla->nota'/>";
        if (isset($error_nota) && $error_nota && $_POST["btnCambiar"] == $tupla->cod_asig) {
          $input .= "<p class='error'> * No has introducido un valor válido de Nota * </p>";
        }
        print "<td>$input</td>";
        $botones .= "<button class='enlace' value='$tupla->cod_asig' name='btnCambiar'>Cambiar</button> - ";
        $botones .= "<button class='enlace' value='$tupla->cod_asig' name='btnAtras'>Atras</button>";
      } else {
        print "<td>$tupla->nota</td>";
        $botones .= "<button class='enlace' value='$tupla->cod_asig' name='btnEditar'>Editar</button> - ";
        $botones .= "<button class='enlace' value='$tupla->cod_asig' name='btnBorrar'>Borrar</button>";
      }

      print "<td>$botones</td>";
      print "</tr>";
      print "</form>";
    }
    print "</table>";


    if (isset($_SESSION["mensaje"])) {
      print "<p class='mensaje'>¡¡" . $_SESSION["mensaje"] . "!!</p>";
      unset($_SESSION["mensaje"]);
    }


    if (count($asignaturas_no_eval) === 0) {
      print "<p>A <strong>$alumno_sel->nombre</strong> no le quedan asignaturas por calificar.</p>";
    } else {
      print "<p><form method='post' action='.'>";
      print "Asignaturas que a <strong>$alumno_sel->nombre</strong> aún le quedan por calificar: ";
      print "<select name='asignatura'>";
      foreach ($asignaturas_no_eval as $tupla) {
        print "<option value='$tupla->cod_asig'>$tupla->denominacion</option>";
      }
      print "</select>";
      print "<input type='hidden' name='alumno' value='$alumno_sel->cod_usu' />";
      print " <button name='btnCalificar'>Calificar</button>";
      print "</form></p>";
    }
  }
  ?>
</body>

</html>