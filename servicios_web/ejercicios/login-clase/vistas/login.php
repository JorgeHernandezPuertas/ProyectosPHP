<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    .error {
      color: red;
    }

    .info {
      color: blue;
    }
  </style>
</head>

<body>
  <h2>Login</h2>
  <?php
  if (isset($_SESSION["mensaje"])) {
    print "<span class='info'>" . $_SESSION["mensaje"] . "</span>";
    session_destroy();
    // unset($_SESSION["mensaje"]);
  }
  ?>
  <form action="index.php" method="post">
    <p>
      <label for="usuario">Usuario:</label>
      <input type="text" name="usuario" id="usuario" value=<?php if (isset($_POST["btnLogin"])) print $_POST["usuario"] ?>>
      <?php
      if (isset($_POST["btnLogin"]) && $error_usuario) {
        if ($_POST["usuario"] === "") {
          print "<span class='error' > * Campo vacío * </span>";
        } else if (strlen($_POST["usuario"]) > 30) {
          print "<span class='error' > * Supera el máximo de caracteres (30) * </span>";
        } else {
          print "<span class='error' > * Usuario/clave no válidos * </span>";
        }
      }
      ?>
    </p>
    <p>
      <label for="psw">Contraseña:</label>
      <input type="password" name="psw" id="psw">
      <?php
      if (isset($_POST["btnLogin"]) && $error_psw) {
        if ($_POST["psw"] === "") {
          print "<span class='error' > * Campo vacío * </span>";
        } else {
          print "<span class='error' > * Supera el máximo de caracteres (16) * </span>";
        }
      }
      ?>
    </p>
    <button name="btnLogin">Login</button>
  </form>
</body>

</html>