<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página normal</title>
  <style>
    .enlace {
      background-color: inherit;
      border: none;
      text-decoration: underline;
      color: blue;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <main>
    <form action="index.php" method="post">
      Bienvenido <strong><?php print $datos_usuario_log->usuario ?></strong><button class="enlace" name="btnSalir">Salir</button>
    </form>
    <p>Tu tipo de usuario es <?php print $datos_usuario_log->tipo ?></p>

  </main>

</body>

</html>