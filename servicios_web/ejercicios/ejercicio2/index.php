<?php
session_name("servicios-actividad1-ejercicio2");
session_start();

if (isset($_POST["btnVolver"])) {
  header("Location: index.php");
  exit;
}

require "./src/utilidad.php";

if (isset($_POST["btnContInsertar"])) {
  // Compruebo que no hay error en el codigo
  $error_cod = $_POST["cod"] == "" || strlen($_POST["cod"]) > 12 || comprobarCodRepetido($_POST["cod"]);
  $error_nombre = $_POST["nom"] != "" && strlen($_POST["nom"]) > 200;
  $error_nom_cor = $_POST["nomCor"] == "" || strlen($_POST["nomCor"]) > 50 || comprobarRepetido("producto", "nombre_corto", $_POST["nomCor"]);
  $error_descripcion = $_POST["desc"] != "" && strlen($_POST["desc"]) > 500;
  $error_pvp = $_POST["pvp"] == "" || !is_numeric($_POST["pvp"]) || !preg_match("/^\d{1,8}(.\d{1,2})?$/", $_POST["pvp"]);
  $error_form = $error_cod || $error_nombre || $error_nom_cor || $error_pvp;

  if (!$error_form) {
    // Si no hay error en el formulario inserto los datos y redirijo al index para borrar el post
    $url = DIR_SERV . "/producto/insertar";
    $datos = array("cod" => $_POST["cod"], "nombre" => $_POST["cod"], "nombre_corto" => $_POST["nomCor"], "descripcion" => $_POST["desc"], "PVP" => $_POST["pvp"], "familia" => $_POST["fam"]);
    $respuesta = consumir_servicios_REST($url, "post", $datos);
    $obj = json_decode($respuesta);
    if (!$obj) die(error_page("Error en el servicio", "<p>Ha ocurrido un error insertando el producto por parte del servicio: $url</p>"));
    if (isset($obj->mensaje_error)) die(error_page("Error en el servicio", "<p>Ha ocurrido un error insertando el producto por parte del servicio: $url</p>"));
    // Si llega aqui es que se ha insertado con éxito por lo que pongo el mensaje en un session y redirijo
    $_SESSION["mensaje"] = $obj->mensaje;
    header("Location:index.php");
    exit;
  }
}

if (isset($_POST["btnContEditar"])) {
  // Compruebo que no hay error en el codigo
  $error_nombre = $_POST["nom"] != "" && strlen($_POST["nom"]) > 200;
  $error_nom_cor = $_POST["nomCor"] == "" || strlen($_POST["nomCor"]) > 50 || comprobarRepetido("producto", "nombre_corto", $_POST["nomCor"], "cod", $_POST["btnContEditar"]);
  $error_descripcion = $_POST["desc"] != "" && strlen($_POST["desc"]) > 500;
  $error_pvp = $_POST["pvp"] == "" || !is_numeric($_POST["pvp"]) || !preg_match("/^\d{1,8}(.\d{1,2})?$/", $_POST["pvp"]);
  $error_form = $error_nombre || $error_nom_cor || $error_pvp;

  if (!$error_form) {
    // Si no hay error en el formulario inserto los datos y redirijo al index para borrar el post
    $url = DIR_SERV . "/producto/actualizar/" . $_POST["btnContEditar"];
    $datos = array("nombre" => $_POST["nom"], "nombre_corto" => $_POST["nomCor"], "descripcion" => $_POST["desc"], "PVP" => $_POST["pvp"], "familia" => $_POST["fam"]);
    $respuesta = consumir_servicios_REST($url, "put", $datos);
    $obj = json_decode($respuesta);
    if (!$obj) die(error_page("Error en el servicio", "<p>Ha ocurrido un error insertando el producto por parte del servicio: $url</p>"));
    if (isset($obj->mensaje_error)) die(error_page("Error en el servicio", "<p>Ha ocurrido un error insertando el producto por parte del servicio: $url</p>"));
    // Si llega aqui es que se ha insertado con éxito por lo que pongo el mensaje en un session y redirijo
    $_SESSION["mensaje"] = $obj->mensaje;
    header("Location:index.php");
    exit;
  }
}

if (isset($_POST["btnContBorrar"])) {
  $url = DIR_SERV . "/producto/borrar/" . $_POST["btnContBorrar"];
  $respuesta = consumir_servicios_REST($url, "delete");
  $obj = json_decode($respuesta);
  if (!$obj) die(error_page("Error en el servicio", "<p>Ha ocurrido un error borrando el producto por parte del servicio: $url</p>"));
  if (isset($obj->mensaje_error)) die(error_page("Error en el servicio", "<p>Ha ocurrido un error borrando el producto por parte del servicio: $url</p>"));

  $_SESSION["mensaje"] = $obj->mensaje;
  header("Location: index.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD Tienda - Actividad 2</title>
  <style>
    table,
    td,
    th {
      text-align: center;
      border: 1px solid black;
      border-collapse: collapse;
    }

    table {
      width: 60%;
      margin: 0 auto;
    }

    td,
    th {
      padding: .5rem;
    }

    h2 {
      text-align: center;
    }

    div {
      width: 60%;
      margin: 0 auto;
      padding-bottom: 1rem;
    }

    .enlace {
      background: inherit;
      border: none;
      color: blue;
      cursor: pointer;
      text-decoration: underline;

      &:hover {
        color: purple;
      }
    }

    .error {
      color: red;
    }

    .mensaje {
      color: blue;
    }
  </style>
</head>

<body>
  <h2>Listado de los Productos</h2>
  <?php
  if (isset($_SESSION["mensaje"])) {
    print "<div class='mensaje'>" . $_SESSION["mensaje"] . "</div>";
    unset($_SESSION["mensaje"]);
  }
  if (isset($_POST["btnInsertar"]) || isset($_POST["btnContInsertar"])) {
    require './vistas/vistaInsertar.php';
  } else if (isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"])) {
    require "./vistas/vistaEditar.php";
  } else if (isset($_POST['btnBorrar'])) {
    require './vistas/vistaBorrar.php';
  } else if (isset($_POST["btnDetalle"])) {
    require './vistas/vistaDetalle.php';
  }

  require './vistas/vistaTabla.php';
  ?>

</body>

</html>