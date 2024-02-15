<?php
session_name("Examen4_SW_23_24");
session_start();

if (isset($_SESSION["usuario"])) {
  require "../src/funciones_ctes.php";
  $salto = "../index.php";
  require "../src/seguridad.php";

  require "../vistas/vista_admin.php";
} else {
  session_destroy();
  header("Location: ../index.php");
  exit;
}
