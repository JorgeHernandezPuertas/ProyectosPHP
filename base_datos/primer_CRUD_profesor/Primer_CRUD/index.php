<?php
session_name("Paginacion_primer_crud_PDO");
session_start();

require "src/ctes_funciones.php";

if (!isset($_SESSION["n_reg_mostrar"])){
    $_SESSION["n_reg_mostrar"] = 3;
}

$_SESSION["pag"] = 1;

if (isset($_POST["pagina"])){
    $_SESSION["pag"] = $_POST["pagina"];
}

if (isset($_POST["btnMostrarRegistros"])){
    $_SESSION["n_reg_mostrar"] = $_POST["num_mostrar"];
}

$ini_limit = ($_SESSION["pag"] - 1) * $_SESSION["n_reg_mostrar"];

if (isset($_POST["btnContBorrar"])) {
    try {
        $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . BD . ";", USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die(error_page("Práctica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }

    try {
        
        $consulta = "delete from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$_POST["btnContBorrar"]]);
    } catch (Exception $e) {
        $conexion = null;
        die(error_page("Práctica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }

    $conexion = null;
    header("Location:index.php");
    exit();
}

if (isset($_POST["btnModCont"])) {
    // Compruebo los errores del formulario
    $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30;
    if (!$error_nombre) {
        try {
            $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . BD . ";", USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }

        $error_nombre = repetido_excluido($conexion, "usuarios", "nombre", $_POST["nombre"], $_POST["btnModCont"]);

        if (is_string($error_nombre))
            die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido buscar en la base de batos: " . $e->getMessage() . "</p>"));
    }

    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["nombre"]) > 20;
    if (!$error_usuario) {
        if (!isset($conexion)) {
            try {
                $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . BD . ";", USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (PDOException $e) {
                die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
            }
        }
        $error_usuario = repetido_excluido($conexion, "usuarios", "usuario", $_POST["usuario"], $_POST["btnModCont"]);

        if (is_string($error_usuario))
            die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido buscar en la base de batos: " . $e->getMessage() . "</p>"));
    }

    $error_clave = strlen($_POST["psw"]) > 15;

    $error_email = $_POST["email"] == "" || strlen($_POST["email"]) > 50;
    if (!$error_email) {
        if (!isset($conexion)) {
            try {
                $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . BD . ";", USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (Exception $e) {
                die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
            }
        }
        $error_email = repetido_excluido($conexion, "usuarios", "email", $_POST["email"], $_POST["btnModCont"]);

        if (is_string($error_email))
            die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }

    $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

    if (!$error_form) {

        // Compruebo que no lo han borrado
        try {
            $consulta = "select * from usuarios where id_usuario = ?";
            $sentencia = $conexion->prepare($consulta);
            $resultado = $sentencia->execute([$_POST["btnModCont"]]);
        } catch (PDOException $e) {
            $conexion = null;
            die(error_page("Práctica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }

        if ($sentencia->rowCount() > 0) { // Si no lo han borrado

            // Modifico el usuario
            try {
                $consulta = "update usuarios set nombre= ?, 
                usuario= ?, clave= ?, email= ?
                where id_usuario= ?";
                $sentencia = $conexion->prepare($consulta);
                $datos = [$_POST["nombre"], $_POST["usuario"], md5($_POST["psw"]), $_POST["email"], $_POST["btnModCont"]];
                $resultado = $sentencia->execute($datos);
            } catch (PDOException $e) {
                $resultado = null;
                $conexion = null;
                die(error_page("Práctica 1º CRUD", "<h1>Listado de los usuarios</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
            }
        }
        $resultado = null;
        $conexion = null;
        header("Location: index.php"); // Redirecciono para no modificar otra vez al refrescar
        exit();
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
            text-align: center;
            margin-top:1rem;
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

        .error {
            color: red;
        }

        p {
            
            padding: 1rem 0;
        }

        p button {
            margin-right: 1rem;
        }

        * {
            margin:0 auto;
            text-align: center;
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

    // Consulto el numero de registros
    try{
        $consulta = "select * from usuarios";
        $num_registros = mysqli_num_rows(mysqli_query($conexion, $consulta));
    } catch (Exception $e){
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    try {
        $consulta = "select * from usuarios limit $ini_limit, ".$_SESSION["n_reg_mostrar"]."";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    // Pongo las opciones de paginacion
    print "<form action='index.php' method='post' >";
    print "<label for='num_mostrar'>Seleccionar registros a visualizar: </label>";
    print "<select id='num_mostrar' name='num_mostrar'>";
    print "<option value='3' >3</option>";
    print "<option value='6' ".(isset($_POST["btnMostrarRegistros"]) && $_SESSION["n_reg_mostrar"] == 6 ? "selected":"" ) ." >6</option>";
    print "<option value='$num_registros' ".(isset($_POST["btnMostrarRegistros"]) && $_SESSION["n_reg_mostrar"] == $num_registros ? "selected":"" ) ." >todos</option>";
    print "</select>";
    print "<button name='btnMostrarRegistros'>Seleccionar</button>";
    print "</form>";

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

    // Después de la tabla ponemos los botones de paginación
    $n_paginas = ceil($num_registros / $_SESSION["n_reg_mostrar"]);
    if ($n_paginas > 1){
        print "<form method='post' action='index.php' ><p>";

        if (1 <> $_SESSION["pag"]){
            print "<button name='pagina' value='1' > |<< </button>";
            print "<button name='pagina' value='".($_SESSION["pag"] - 1)."' > < </button>";
        }

        for ($i=1; $i <= $n_paginas; $i++) { 
            print "<button name='pagina' value='$i' >$i</button>";
        }

        if ($n_paginas <> $_SESSION["pag"]){
            print "<button name='pagina' value='".($_SESSION["pag"] + 1)."' > > </button>";
            print "<button name='pagina' value='$n_paginas' > >>| </button>";
        }

        print "</p></form>";
    }
    

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
    } else if (isset($_POST["btnEditar"]) || isset($_POST["btnModCont"])) {
        $id_actual = isset($_POST["btnEditar"]) ? $_POST["btnEditar"] : $_POST["btnModCont"];
        print "<h3>Editando al usuario " . $id_actual . "</h3>";


        try {
            $consulta = "select * from usuarios where id_usuario='" . $id_actual . "'";
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
                    if (isset($_POST["btnModCont"]) && $error_nombre) {
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
                    if (isset($_POST["btnModCont"]) && $error_usuario) {
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
                    if (isset($_POST["btnModCont"]) && $error_clave) {
                        print "<span class='error'> * El tamaño máximo del nombre es de 30 carácteres * </span>";
                    }
                    ?>
                </p>
                <p>
                    <label for="email">Email: </label>
                    <input type="text" name="email" id="email" value="<?php print $datos_usuario["email"] ?>">
                    <?php
                    if (isset($_POST["btnModCont"]) && $error_email) {
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
                    <button type="submit" name="btnModCont" value="<?php print $id_actual ?>">Continuar</button>
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