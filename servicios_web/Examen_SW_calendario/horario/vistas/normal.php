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

    .libros {
      width: 90%;
      max-width: 90%;
      margin: 0 auto;
      display: flex;
      flex-flow: row wrap;
      justify-content: space-between;
    }

    .libros div {
      flex: 30% 0;
      max-width: 30%;
      text-align: center;
    }

    .enlace {
      color: blue;
      text-decoration: underline;
      background-color: inherit;
      border: none;
    }
  </style>
</head>

<body>
  <h1>Librería</h1>
  <form method="post" action="index.php">Bienvenido <?php print $_SESSION["lector"] ?> - <button class="enlace" name="btnSalir">Salir</button></form>
  <?php
  require "./vistas/listadoLibros.php";
  ?>
</body>

</html>