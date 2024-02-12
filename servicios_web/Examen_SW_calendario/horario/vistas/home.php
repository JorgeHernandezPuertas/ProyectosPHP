<?php
if (isset($_POST["btnLogin"])) {
  $error_usuario = $_POST["lector"] === "" || strlen($_POST["lector"]) > 15;
  $error_psw = $_POST["psw"] === "" || strlen($_POST["psw"]) > 20;
  $error_form = $error_usuario || $error_psw;

  if (!$error_form) {
    $url = DIR_SERV . "/login";
    $datos = array("lector" => $_POST["lector"], "clave" => md5($_POST["psw"]));
    $resultado = consumir_servicios_REST($url, "post", $datos);
    $obj = json_decode($resultado);
    if (!$obj) {
      session_destroy();
      die(error_page("Error consumiendo el servicio web", "<h2>Error consumiendo el servicio web</h2><p>$url</p>"));
    } else if (isset($obj->mensaje)) {
      $error_usuario = true;
    }

    if (isset($obj->usuario)) {
      $_SESSION["lector"] = $obj->usuario->lector;
      $_SESSION["clave"] = $obj->usuario->clave;
      $_SESSION["tipo"] = $obj->usuario->tipo;
      $_SESSION["api_session"] = $obj->api_session;
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

    .error {
      color: red;
    }
  </style>
</head>

<body>
  <h1>Librería</h1>
  <form action="index.php" method="post">
    <p>
      <label for="lector">Nombre de usuario </label>
      <input type="text" name="lector" id="lector" value='<?php if (isset($_POST["btnLogin"])) print $_POST["lector"] ?>'>
      <?php
      if (isset($_POST["btnLogin"]) && $error_usuario) {
        if ($_POST["lector"] === "") {
          print "<span class='error'> * Campo vacío * </span>";
        } else if (strlen($_POST["lector"]) > 15) {
          print "<span class='error'> * Has superado el máximo de caracteres (15) * </span>";
        } else {
          print "<span class='error'> * Usuario o contraseña incorrectos * </span>";
        }
      }
      ?>
    </p>
    <p>
      <label for="psw">Contraseña </label>
      <input type="password" name="psw" id="psw">
      <?php
      if (isset($_POST["btnLogin"]) && $error_psw) {
        if ($_POST["psw"] === "") {
          print "<span class='error'> * Campo vacío * </span>";
        } else if (strlen($_POST["psw"]) > 20) {
          print "<span class='error'> * Has superado el máximo de caracteres (20) * </span>";
        } else {
          print "<span class='error'> * Usuario o contraseña incorrectos * </span>";
        }
      }
      ?>
    </p>
    <button name="btnLogin">Entrar</button>
  </form>
  <?php
  require "./vistas/listadoLibros.php";
  ?>
</body>

</html>