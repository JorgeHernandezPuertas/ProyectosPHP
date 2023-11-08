<?php
require "src/ctes_funciones.php";

if (isset($_POST["btnContBorrar"])) {
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("Práctica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }

    try {
        $consulta = "delete from usuarios where id_usuario='" . $_POST["btnContBorrar"] . "'";
        mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("Práctica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }

    mysqli_close($conexion);
    header("Location:index.php");
    exit();
}

if (isset($_POST["btnContMod"])) {
    // Compruebo los errores del formulario
    $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30;
    if (!$error_nombre) {
        try {
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }

        $error_nombre = repetido_excluido($conexion, "usuarios", "nombre", $_POST["nombre"], $_POST["btnContMod"]);

        if (is_string($error_nombre))
            die($error_nombre);
    }

    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["nombre"]) > 20;
    if (!$error_usuario) {
        if (!isset($conexion)) {
            try {
                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
            }
        }
        $error_usuario = repetido_excluido($conexion, "usuarios", "usuario", $_POST["usuario"], $_POST["btnContMod"]);

        if (is_string($error_usuario))
            die($error_usuario);
    }

    $error_clave = strlen($_POST["psw"]) > 15;

    $error_email = $_POST["email"] == "" || strlen($_POST["email"]) > 50;
    if (!$error_email) {
        if (!isset($conexion)) {
            try {
                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
            }
        }
        $error_email = repetido_excluido($conexion, "usuarios", "email", $_POST["email"], $_POST["btnContMod"]);

        if (is_string($error_email))
            die($error_email);
    }
    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

    if (!$error_form) {

        // Compruebo que no lo han borrado
        try {
            $consulta = "select * from usuarios where id_usuario='" . $_POST["btnContMod"] . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("Práctica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }

        if (mysqli_num_rows($resultado) > 0) { // Si no lo han borrado
            // Modifico el usuario
            try {
                $consulta = "update usuarios set 'nombre'=" . $_POST["nombre"] . ", 
                            'usuario'=" . $_POST["usuario"] . ", 'clave'=" . md5($_POST["psw"]) . " 'email'=" . $_POST["email"] . "
                            where id_usuario='" . $_POST["btnContMod"] . "'";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die(error_page("Práctica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
            }
        }
        mysqli_free_result($resultado);
        mysqli_close($conexion);
        header("Location: index.php"); // Redirecciono para no modificar otra vez al refrescar
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1º CRUD</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black
        }

        table {
            border-collapse: collapse;
            text-align: center
        }

        th {
            background-color: #CCC
        }

        table img {
            width: 50px;
        }

        .enlace {
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline
        }
    </style>
</head>

<body>
    <h1>Listado de los usuarios</h1>
    <?php
    if (!isset($conexion)) {
        try {
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_foro");
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("<p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
        }
    }

    try {
        $consulta = "select * from usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    echo "<table>";
    echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnDetalle' title='Detalles del Usuario'>" . $tupla["nombre"] . "</button></form></td>";
        echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='" . $tupla["nombre"] . "'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnBorrar'><img src='images/borrar.png' alt='Imagen de Borrar' title='Borrar Usuario'></button></form></td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnEditar'><img src='images/editar.png' alt='Imagen de Editar' title='Editar Usuario'></button></form></td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($resultado);

    if (isset($_POST["btnDetalle"])) {
        echo "<h3>Detalles del usuario con id: " . $_POST["btnDetalle"] . "</h3>";
        try {
            $consulta = "select * from usuarios where id_usuario='" . $_POST["btnDetalle"] . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
        }

        if (mysqli_num_rows($resultado) > 0) {
            $datos_usuario = mysqli_fetch_assoc($resultado);
            mysqli_free_result($resultado);

            echo "<p>";
            echo "<strong>Nombre: </strong>" . $datos_usuario["nombre"] . "<br>";
            echo "<strong>Usuario: </strong>" . $datos_usuario["usuario"] . "<br>";
            echo "<strong>Email: </strong>" . $datos_usuario["email"];
            echo "</p>";
        } else
            echo "<p>El usuario seleccionado ya no se encuentra registrado en la BD</p>";


        echo "<form action='index.php' method='post'>";
        echo "<p><button type='submit'>Volver</button></p>";
        echo "</form>";
    } else if (isset($_POST["btnBorrar"])) {
        echo "<p>Se dispone usted a borrar a usuario <strong>" . $_POST["nombre_usuario"] . "</strong></p>";
        echo "<form action='index.php' method='post'>";
        echo "<p><button type='submit' name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Continuar</button> ";
        echo "<button type='submit'>Atrás</button></p>";
        echo "</form>";
    } else if (isset($_POST["btnEditar"]) || isset($error_form)) {

        print "<h3>Editando al usuario " . $_POST["btnEditar"] . "</h3>";


        try {
            $consulta = "select * from usuarios where id_usuario='" . $_POST["btnEditar"] . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
        }

        if (mysqli_num_rows($resultado) > 0) { // Si no esta borrado
            $datos_usuario = mysqli_fetch_assoc($resultado);
            mysqli_close($conexion);

    ?>
            <form action="index.php" method="post">
                <p>
                    <label for="nombre">Nombre: </label>
                    <input type="text" name="nombre" id="nombre" value="<?php print $datos_usuario["nombre"] ?>">
                    <?php
                    if (isset($error_form) && $error_nombre) {
                        if ($_POST["nombre"] == "") {
                            print "<span class='error'> * Campo vacío * </span>";
                        } else if (strlen($_POST["nombre"]) > 30) {
                            print "<span class='error'> * El tamaño máximo del nombre es de 30 carácteres * </span>";
                        } else {
                            print "<span class='error'> * Ese nombre ya está en uso * </span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <label for="usuario">Usuario: </label>
                    <input type="text" name="usuario" id="usuario" value="<?php print $datos_usuario["usuario"] ?>">
                    <?php
                    if (isset($error_form) && $error_usuario) {
                        if ($_POST["usuario"] == "") {
                            print "<span class='error'> * Campo vacío * </span>";
                        } else if (strlen($_POST["usuario"]) > 20) {
                            print "<span class='error'> * El tamaño máximo del nombre es de 20 carácteres * </span>";
                        } else {
                            print "<span class='error'> * Ese usuario ya está en uso * </span>";
                        }
                    }
                    ?>
                </p>

                <p>
                    <label for="psw">Contraseña: </label>
                    <input type="password" name="psw" id="psw" placeholder="Editar contraseña">
                    <?php
                    if (isset($error_form) && $error_clave) {
                        print "<span class='error'> * El tamaño máximo del nombre es de 30 carácteres * </span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="email">Email: </label>
                    <input type="text" name="email" id="email" value="<?php print $datos_usuario["email"] ?>">
                    <?php
                    if (isset($error_form) && $error_email) {
                        if ($_POST["email"] == "") {
                            print "<span class='error'> * Campo vacío * </span>";
                        } else if (strlen($_POST["email"]) > 20) {
                            print "<span class='error'> * El tamaño máximo del nombre es de 20 carácteres * </span>";
                        } else {
                            print "<span class='error'> * Ese email ya está en uso * </span>";
                        }
                    }
                    ?>
                </p>
                <p>
                    <button type="submit" name="btnModCont" value="<?php print $_POST["btnEditar"] ?>">Continuar</button>
                    <button type="submit">Atrás</button>
                </p>
            </form>
    <?php
        }
    } else {
        echo "<form action='usuario_nuevo.php' method='post'>";
        echo "<p><button type='submit' name='btnNuevoUsuario'>Insertar nuevo Usuario</button></p>";
        echo "</form>";
    }

    ?>
</body>

</html>