<?php
if (isset($_POST["btnEntrar"])) {
    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 20;
    $error_clave = $_POST["clave"] == "" || strlen($_POST["clave"]) > 15;
    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        $url = DIR_SERV . "/login";
        $datos = array("usuario" => $_POST["usuario"], "clave" => md5($_POST["clave"]));
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj = json_decode($respuesta);
        if (!$obj) {
            session_destroy();
            die(error_page("ERROR", "<p>Error consumiendo el servicio: " . $url . "</p>"));
        }

        if (isset($obj->error)) {
            session_destroy();
            die(error_page("ERROR", "<p>" . $obj->error . "</p>"));
        }

        if (isset($obj->mensaje)) {
            $error_usuario = true;
        } else {
            $_SESSION["usuario"] = $obj->usuario->usuario;
            $_SESSION["clave"] = $obj->usuario->clave;
            $_SESSION["api_session"] = $obj->api_session;
            $_SESSION["ult_acc"] = time();
            header("Location: index.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesores 2 SW</title>
    <style>
        .error {
            color: red;
        }

        .mensaje {
            color: blue;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <h1>Profesores 2 SW</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"] ?>">
            <?php
            if (isset($_POST["usuario"]) && $error_usuario) {
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'> Campo vacío</span>";
                } else if (strlen($_POST["usuario"]) > 20) {
                    echo "<span class='error'> No puede superar los 20 caracteres.</span>";
                } else {
                    echo "<span class='error'> Usuario / Contraseña incorrectos.</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" maxlength="15">
            <?php
            if (isset($_POST["clave"]) && $error_clave) {
                if ($_POST["clave"] == "") {
                    echo "<span class='error'> Campo vacío</span>";
                } else {
                    echo "<span class='error'> No puede superar los 15 caracteres.</span>";
                }
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnEntrar">Entrar</button>
        </p>
    </form>
    <?php
    if (isset($_SESSION["seguridad"])) {
        echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";
        session_destroy();
    }
    ?>
</body>

</html>