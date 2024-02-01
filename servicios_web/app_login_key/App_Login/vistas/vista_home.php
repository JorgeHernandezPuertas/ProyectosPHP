<?php
if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;
    if (!$error_form) {
        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);
        $url = DIR_SERV . "/login";
        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta);
        if (!$obj) {
            session_destroy();
            die(error_page("App Login SW", "<h1>App Login SW</h1>" . $respuesta));
        }

        if (isset($obj->error)) {
            session_destroy();
            die(error_page("App Login SW", "<h1>App Login SW</h1><p>" . $obj->error . "</p>"));
        }

        if (isset($obj->mensaje))
            $error_usuario = true;
        else {
            $_SESSION["usuario"] = $obj->usuario->usuario;
            $_SESSION["clave"] = $obj->usuario->clave;
            $_SESSION["api_key"] = $obj->api_key;
            $_SESSION["ult_accion"] = time();
            header("Location:index.php");
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Login SW</title>
</head>

<body>
    <h1>App Login SW</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
            <?php
            if (isset($_POST["btnLogin"]) && $error_usuario)
                if ($_POST["usuario"] == "")
                    echo "<span class='error'> Campo vacío</span>";
                else
                    echo "<span class='error'> Usuario/clave no válidos</span>";
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["btnLogin"]) && $error_clave)
                echo "<span class='error'> Campo vacío</span>";
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin">Login</button>

        </p>
    </form>
    <?php
    if (isset($_SESSION["seguridad"])) {
        echo "<p class='mesaje'>" . $_SESSION["seguridad"] . "</p>";
        session_destroy();
    }
    ?>
</body>

</html>