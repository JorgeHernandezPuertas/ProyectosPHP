<?php
session_name("actividad5-sw");
session_start();
require "./utils.php";

if (isset($_POST["btnNuevoUsuario"]) || isset($_POST["btnContinuar"])) {
    if (isset($_POST["btnContinuar"])) {

        $error_form = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30
            || $_POST["usuario"] == "" ||  strlen($_POST["usuario"]) > 20
            || $_POST["psw"] == "" ||  strlen($_POST["psw"]) > 15
            || $_POST["email"] == "" ||  strlen($_POST["email"]) > 50 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

        if (!$error_form)
            $error_form = comprobarRepetido("usuarios", "usuario", $_POST["usuario"]) || comprobarRepetido("usuarios", "email", $_POST["email"]);

        if (!$error_form) {
            $datos = array("nombre" => $_POST["nombre"], "usuario" => $_POST["usuario"], "clave" => md5($_POST["psw"]), "email" => $_POST["email"]);
            $obj = json_decode(consumir_servicios_REST(DIR_SERV . "/crearUsuario", "post", $datos));
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
        <title>Nuevo Usuario</title>
        <style>
            .error {
                color: red;
            }
        </style>
    </head>

    <body>
        <h1>Nuevo Usuario</h1>

        <form action="usuario_nuevo.php" method="post">
            <p>
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if (isset($_POST["nombre"])) print $_POST["nombre"] ?>">
                <?php
                if (isset($_POST["btnContinuar"])) {
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
                if (isset($_POST["btnContinuar"]) && $error_form) {
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
                if (isset($_POST["btnContinuar"])) {
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
                if (isset($_POST["btnContinuar"]) && $error_form) {
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
                <button type="submit" name="btnContinuar" id="boton-continuar">Continuar</button>
                <button type="submit" name="btnVolver" id="boton-volver">Volver</button>
            </p>
        </form>
    </body>

    </html>
<?php
} else {
    header("Location: index.php");
}
?>