<?php
if (isset($_POST["btnContBorrar"])) {
  $obj = json_decode(consumir_servicios_REST(DIR_SERV . "/borrarUsuario/" . $_POST["btnContBorrar"], "delete"));
  if (!$obj) {
    die(error_page("Primer CRUD con SW", "<h2>Error consumiendo el servicio web</h2>"));
  } else if (isset($obj->error)) {
    die(error_page("Primer CRUD con SW", "<h2>Error consumiendo el servicio web</h2><p>$obj->error</p>"));
  }
}

if (isset($_POST["btnContEditar"])) {
  $error_form = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30
    || $_POST["usuario"] == "" ||  strlen($_POST["usuario"]) > 20
    || $_POST["psw"] == "" ||  strlen($_POST["psw"]) > 15
    || $_POST["email"] == "" ||  strlen($_POST["email"]) > 50 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

  if (!$error_form)
    $error_form = comprobarRepetido("usuarios", "usuario", $_POST["usuario"], "id_usuario", $_POST["btnContEditar"]) || comprobarRepetido("usuarios", "email", $_POST["email"], "id_usuario", $_POST["btnContEditar"]);

  if (!$error_form) {
    $datos = array("nombre" => $_POST["nombre"], "usuario" => $_POST["usuario"], "clave" => md5($_POST["psw"]), "email" => $_POST["email"]);
    $obj = json_decode(consumir_servicios_REST(DIR_SERV . "/actualizarUsuario/" . $_POST["btnContEditar"], "put", $datos));
    if (!$obj) {
      die(error_page("Primer CRUD con SW", "<h2>Error consumiendo el servicio web</h2>"));
    } else if (isset($obj->error)) {
      die(error_page("Primer CRUD con SW", "<h2>Error consumiendo el servicio web</h2><p>$obj->error</p>"));
    }
    header("Location: index.php");
    exit;
  }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Práctica CRUD</title>
  <style>
    table,
    th,
    td,
    tr {
      border-collapse: collapse;
      border: 1px solid black;
      text-align: center;
    }

    th {
      background-color: #CCC;
    }

    td button {
      cursor: pointer;
      background-color: white;
      border: none;
    }

    .enlace {
      color: blue;
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <h1>Listado de los usuarios</h1>
  <?php
  $obj = json_decode(consumir_servicios_REST(DIR_SERV . "/usuarios", "get"));
  if (!$obj) {
    die("<h2>Error consumiendo el servicio web</h2></body></html>");
  } else if (isset($obj->error)) {
    die("<h2>Error consumiendo el servicio web</h2><p>$obj->error</p></body></html>");
  }


  print "<table><tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";
  foreach ($obj->usuarios as $tupla) {
    print "<tr>
        <td>
        <form  action='index.php' method='post'>
        <button class='enlace' type='submit' name='btnDetalle' value='" . $tupla->id_usuario . "' >
        " . $tupla->usuario . "
        </button>
        </form>
        </td>
        <td>
        <form  action='index.php' method='post'>
        <input type='hidden' name='nombreUsuario' value='" . $tupla->usuario . "'>
        <button type='submit' name='btnBorrar' value='" . $tupla->id_usuario . "' >
        <img src='images/borrar.png' alt='Imagen de una cruz' width='50' title='Borrar usuario' >
        </form>
        </td>
        </button>
        <td>
        <form  action='index.php' method='post'>
        <button type='submit' name='btnEditar' value='" . $tupla->id_usuario . "' >
        <img src='images/modificar.png' alt='Imagen de un lapiz' width='50' title='Editar usuario' >
        </button>
        </form>
        </td>
        </tr>";
  }
  print "</table>";

  if (isset($_POST["btnDetalle"])) {
    // Código para listar detalles

    print "<h3>Detalles del usuario con id: " . $_POST["btnDetalle"] . "</h3>";

    $obj = json_decode(consumir_servicios_REST(DIR_SERV . "/usuario/" . $_POST["btnDetalle"], "get"));
    if (!$obj) {
      die(error_page("Primer CRUD con SW", "<h2>Error consumiendo el servicio web</h2>"));
    } else if (isset($obj->error)) {
      die(error_page("Primer CRUD con SW", "<h2>Error consumiendo el servicio web</h2><p>$obj->error</p>"));
    } else if (isset($obj->mensaje_error)) {
      print "<p>El usuario seleccionado ha sido eliminado de la base de datos</p>";
    } else {
      $datos_usuario = $obj->usuario;
      print "<p><strong>Nombre:</strong> " . $datos_usuario->nombre . "</p>";
      print "<p><strong>Usuario:</strong> " . $datos_usuario->usuario . "</p>";
      print "<p><strong>Email:</strong> " . $datos_usuario->email . "</p>";
    }
  ?>
    <form action="index.php">
      <button type="submit">Volver</button>
    </form>
  <?php
  } else if (isset($_POST["btnBorrar"])) {
    // Código para borrar
    print "<p>Se dispone usted a borrar al usuario <strong>" . $_POST["nombreUsuario"] . "</strong></p>";

    print "<form action='index.php' method='post'>";
    print "<p>
        <button type='submit' name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Continuar</button>
        <button type='submit'>Atrás</button>
        </p>";
    print "</form>";
  } else if (isset($_POST["btnEditar"])) {
    // Código para editar
  ?>
    <h2>Editando el usuario <?php print $_POST["btnEditar"] ?></h2>

    <form action="index.php" method="post">
      <p>
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if (isset($_POST["nombre"])) print $_POST["nombre"] ?>">
        <?php
        if (isset($_POST["btnContEditar"])) {
          if ($_POST["nombre"] == "") {
            print "<span class='error'> * Campo obligatorio * </span>";
          } else if (strlen($_POST["nombre"]) > 30) {
            print "<span class='error'> * El tamaño máximo del nombre es de 30 caracteres * </span>";
          }
        }
        ?>
      </p>
      <p>
        <label for="usuario">Usuario: </label>
        <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if (isset($_POST["usuario"])) print $_POST["usuario"] ?>">
        <?php
        if (isset($_POST["btnContEditar"]) && $error_form) {
          if ($_POST["usuario"] == "") {
            print "<span class='error'> * Campo obligatorio * </span>";
          } else if (strlen($_POST["usuario"]) > 20) {
            print "<span class='error'> * El tamaño máximo del usuario es de 20 caracteres * </span>";
          } else {
            print "<span class='error'> * Ese usuario ya está en uso * </span>";
          }
        }
        ?>
      </p>
      <p>
        <label for="psw">Contraseña: </label>
        <input type="password" name="psw" id="psw" maxlength="15">
        <?php
        if (isset($_POST["btnContEditar"])) {
          if ($_POST["psw"] == "") {
            print "<span class='error'> * Campo obligatorio * </span>";
          } else if (strlen($_POST["psw"]) > 15) {
            print "<span class='error'> * El tamaño máximo de la contraseña es de 15 caracteres * </span>";
          }
        }
        ?>
      </p>
      <p>
        <label for="email">Email: </label>
        <input type="text" name="email" id="email" maxlength="50" value="<?php if (isset($_POST["email"])) print $_POST["email"] ?>">
        <?php
        if (isset($_POST["btnContEditar"]) && $error_form) {
          if ($_POST["email"] == "") {
            print "<span class='error'> * Campo obligatorio * </span>";
          } else if (strlen($_POST["email"]) > 50) {
            print "<span class='error'> * El tamaño máximo del email es de 50 caracteres * </span>";
          } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            print "<span class='error'> * El email introducido no es un email válido. * </span>";
          } else {
            print "<span class='error'> * Ese email ya está en uso * </span>";
          }
        }
        ?>
      </p>
      <p>
        <button type="submit" name="btnContEditar" value=<?php print $_POST["btnEditar"] ?> id="boton-continuar">Continuar</button>
        <button type="submit" name="btnVolver" id="boton-volver">Volver</button>
      </p>
    </form>
  <?php
  } else {
  ?>
    <form action="usuario_nuevo.php" method="post">
      <p>
        <button name="btnNuevoUsuario" id="boton-enviar" type="submit">Insertar nuevo usuario</button>
      </p>
    </form>
  <?php
  }
  ?>




</body>

</html>