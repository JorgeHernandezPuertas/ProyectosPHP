<?php

function error_page($title, $body)
{
    $page = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>
        ' . $body . '
    </body>
    </html>';

    return $page;
}

if (isset($_POST["btnNuevoUsuario"]) || isset($_POST["btnContinuar"])) {
    if (isset($_POST["btnContinuar"])) {

        $error_form = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30
            || $_POST["usuario"] == "" ||  strlen($_POST["usuario"]) > 20
            || $_POST["psw"] == "" ||  strlen($_POST["psw"]) > 15
            || $_POST["email"] == "" ||  strlen($_POST["email"]) > 50 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

            if (!$error_form) { // Compruebo que los valores introducidos no esten repetidos en la BD
                try {
                    require "constantes_conexion.php";
                    $conexion = mysqli_connect(HOST, USER, PWD, BD);
                } catch (mysqli_sql_exception $e) {
                    die(error_page("Práctica 1º CRUD", "<h1> Práctica 1º CRUD </h1><p class='error'> No se ha podido establecer la conexión con la base de datos ". $e -> getMessage()." </p>"));
                }
    
                $consulta = "select usuario, email from usuarios";
    
                try {
                    $resultado = mysqli_query($conexion, $consulta);
                } catch (mysqli_sql_exception $e) {
                    mysqli_close($conexion);
                    die(error_page("Práctica 1º CRUD", "<h1> Práctica 1º CRUD </h1><p class='error'> No se ha podido hacer la búsqueda en la base de datos ". $e -> getMessage()." </p>"));
                }
    
                while ($tupla = mysqli_fetch_assoc($resultado)) {
                    // Compruebo si  hay algún repetido
                    $usuario_repe = $tupla["usuario"] == $_POST["usuario"];
                    $email_repe =  $tupla["email"] == $_POST["email"];
                    $error_form = $error_form || $usuario_repe || $email_repe;
    
                    if ($error_form) { // Si encuentro un repetido salgo
                        break;
                    }
                }
                if (!$error_form){
                    $consulta = "insert into usuarios (nombre, usuario, clave, email) values ('" . $_POST["nombre"] . "', '" . $_POST["usuario"] . "', '" . md5($_POST["psw"]) . "', '" . $_POST["email"] . "')";
    
                    try {
                        mysqli_query($conexion, $consulta);
                    } catch (mysqli_sql_exception $e) {
                        mysqli_close($conexion);
                        die(error_page("Práctica 1º CRUD", "<h1> Práctica 1º CRUD </h1><p class='error'> Ha ocurrido un error insertando los datos " . $e->getMessage() . "</p>"));
                    }
                    mysqli_close($conexion);
                    header("Location: index.php");
                    exit;
                }
                mysqli_close($conexion);
                
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
                if (isset($_POST["btnContinuar"])) {
                    if ($_POST["usuario"] == "") {
                        print "<span class='error'> * Campo obligatorio * </span>";
                    } else if (strlen($_POST["usuario"]) > 20) {
                        print "<span class='error'> * El tamaño máximo del usuario es de 20 caracteres * </span>";
                    } else if ($usuario_repe) {
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
                if (isset($_POST["btnContinuar"])) {
                    if ($_POST["email"] == "") {
                        print "<span class='error'> * Campo obligatorio * </span>";
                    } else if (strlen($_POST["email"]) > 50) {
                        print "<span class='error'> * El tamaño máximo del email es de 50 caracteres * </span>";
                    } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                        print "<span class='error'> * El email introducido no es un email válido. * </span>";
                    } else if ($email_repe) {
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
        <?php
        
        ?>
    </body>

    </html>
<?php
} else {
    header("Location: index.php");
}
?>