<?php

if (isset($_POST["btnVolver"])) {
  header("Location: index.php");
  exit;
}

require "./src/utilidad.php";

if (isset($_POST["btnContInsertar"])) {
  // Compruebo que no hay error en el codigo
  $error_cod = $_POST["cod"] == "" || strlen($_POST["cod"]) > 12 || comprobarCodRepetido($_POST["cod"]);
  $error_nombre = $_POST["nom"] != "" || strlen($_POST["nom"]) > 200;
  $error_nom_cor = $_POST["nomCor"] == "" || strlen($_POST["nomCor"]) > 50 || comprobarRepetido("producto", "nombre_corto", $_POST["nomCor"]);
  $error_form = $error_cod;
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
  </style>
</head>

<body>
  <h2>Listado de los Productos</h2>
  <?php
  if (isset($_POST["btnInsertar"]) || isset($_POST["btnContInsertar"])) {
    require './vistas/vistaInsertar.php';
  }

  require './vistas/vistaTabla.php';
  ?>

</body>

</html>