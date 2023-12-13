<?php
if (isset($_POST["btnContRegistrar"])) {

    $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30;
    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 20;
    if (!$error_usuario) {


        $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);

        if (is_string($error_usuario)) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Primer Login", "<h1>Primer Login</h1><p>No se ha podido realizar la consulta: " . $error_usuario . "</p>"));
        }
    }

    $error_clave = $_POST["clave"] == "" || strlen($_POST["clave"]) > 15;
    $error_email = $_POST["email"] == "" || strlen($_POST["email"]) > 50 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    if (!$error_email) {

        $error_email = repetido($conexion, "usuarios", "email", $_POST["email"]);

        if (is_string($error_email)) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No ha podido realizarse la consulta: " . $error_email . "</p>"));
        }
    }
    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

    if (!$error_form) {
        try {
            $consulta = "insert into usuarios (nombre,usuario,clave,email,tipo) values ('" . $_POST["nombre"] . "','" . $_POST["usuario"] . "','" . md5($_POST["clave"]) . "','" . $_POST["email"] . "','" . $_POST["tipo"] . "')";
            mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>"));
        }

        $_SESSION["mensaje"] = "El usuario ha sido creado con éxito";
        header("Location:index.php");
        exit;
    }
}
?>
<div class="centrado">
    <h2>Usuario Nuevo</h2>
    <form action="index.php" method="post">
        <p>
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
            <?php
            if (isset($_POST["btnContInsertar"]) && $error_nombre) {
                if ($_POST["nombre"] == "")
                    echo "<span class='error'> Campo vacío</span>";
                else
                    echo "<span class='error'> Has tecleado más de 30 caracteres</span>";
            }
            ?>
        </p>
        <p>
            <label for="usuario">Usuario: </label>
            <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
            <?php
            if (isset($_POST["btnContInsertar"]) && $error_usuario) {
                if ($_POST["usuario"] == "")
                    echo "<span class='error'> Campo vacío</span>";
                elseif (strlen($_POST["usuario"]) > 20)
                    echo "<span class='error'> Has tecleado más de 20 caracteres</span>";
                else
                    echo "<span class='error'> Usuario repetido</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" maxlength="15" id="clave">
            <?php
            if (isset($_POST["btnContInsertar"]) && $error_clave) {
                if ($_POST["clave"] == "")
                    echo "<span class='error'> Campo vacío</span>";
                else
                    echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
            }
            ?>
        </p>
        <p>
            <label for="email">Email: </label>
            <input type="text" name="email" id="email" maxlength="50" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>">
            <?php
            if (isset($_POST["btnContInsertar"]) && $error_email) {
                if ($_POST["email"] == "")
                    echo "<span class='error'> Campo vacío</span>";
                elseif (strlen($_POST["email"]) > 50)
                    echo "<span class='error'> Has tecleado más de 50 caracteres</span>";
                elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                    echo "<span class='error'> Email sintáxticamente incorrecto</span>";
                else
                    echo "<span class='error'> Email repetido</span>";
            }
            ?>
        </p>
        <p>
            <button type="submit" name="btnContRegistrar">Continuar</button>
            <button type="submit">Volver</button>
        </p>
    </form>
</div>
