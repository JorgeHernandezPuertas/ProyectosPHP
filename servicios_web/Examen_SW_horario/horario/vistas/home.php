<?php
if (isset($_POST["btnLogin"])) {
  // Compruebo errores
  $error_usuario = $_POST["usuario"] === "";
  $error_clave = $_POST["clave"] === "";
  $error_form = $error_usuario || $error_clave;

  if (!$error_form) {
    $url = DIR_SERV . "/login";
    $datos = array("usuario" => $_POST["usuario"], "clave" => md5($_POST["clave"]));
    $resultado = consumir_servicios_REST($url, "post", $datos);
    $obj = json_decode($resultado);
    // Si da error
    if (!isset($obj)) {
      session_destroy();
      die(error_page("Práctica examen - horarios", "<h2>Error consumiendo el servicio</h2><p>En la url: $url</p>"));
    } else if (isset($obj->error)) {
      session_destroy();
      die(error_page("Práctica examen - horarios", "<h2>Error consumiendo el servicio</h2><p>Error: $obj->error</p>"));
    } else if (isset($obj->mensaje)) { // Si no existe el usuario o la contraseña
      $error_usuario = true;
      $error_form = true;
    } else { // Si se ha logeado bien
      // Creo sus variables de sesion y lo redirijo a index
      $_SESSION["api_session"] = $obj->api_session;
      $_SESSION["usuario"] = $obj->usuario->usuario;
      $_SESSION["clave"] = $obj->usuario->clave;
      $_SESSION["ult_accion"] = time();
      header("Location: index.php");
      exit;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Examen horario - Home</title>
  <style>
    .error {
      color: red
    }

    .seguridad {
      color: blue;
    }
  </style>
</head>

<body>
  <h2>Login</h2>
  <form action="index.php" method="post">
    <p>
      <label for="usuario">Usuario: </label>
      <input type="text" name="usuario" id="usuario" value=<?php if (isset($_POST["usuario"])) print $_POST["usuario"] ?>>
      <?php
      if (isset($_POST["btnLogin"]) && $error_usuario) {
        if ($_POST["usuario"] === "") {
          print "<span class='error'>* Campo vacío *</span>";
        } else {
          print "<span class='error'>* Usuario o contraseña erroneos *</span>";
        }
      }
      ?>
    </p>
    <p>
      <label for="clave">Contraseña: </label>
      <input type="password" name="clave" id="clave">
      <?php
      if (isset($_POST["btnLogin"]) && $error_clave) {
        print "<span class='error'>* Campo vacío *</span>";
      }
      ?>
    </p>
    <button name="btnLogin">Entrar</button>
  </form>
  <?php
  if (isset($_SESSION["seguridad"])) {
    print "<p class='seguridad'>" . $_SESSION["seguridad"] . "</p>";
    unset($_SESSION["seguridad"]);
  }
  ?>
</body>

</html>