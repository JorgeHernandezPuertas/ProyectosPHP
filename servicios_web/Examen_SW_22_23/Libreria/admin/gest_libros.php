<?php
session_name("liberia-SW-practica-examen");
session_start();

$salto = "../index.php";
require "../src/seguridad.php";

if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] === "admin") {
?>
  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de admin</title>
  </head>

  <body>
    <h2>Hola</h2>
  </body>

  </html>
<?php
} else {
  header("Location: ../index.php");
}
?>