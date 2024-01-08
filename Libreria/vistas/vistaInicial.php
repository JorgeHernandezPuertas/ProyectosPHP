<?php
if (isset($_POST["btnSalir"])) {
    session_destroy();
    mysqli_close($conexion);
    header("Location: index.php");
    exit;
}

if (isset($_POST["btnEntrar"])) {

    $error_form = $_POST["usuario"] == "" || $_POST["psw"] == "";
    if (!$error_form) {
        // Me conecto a la BD
        $conexion = conectarBD();
        if (is_string($conexion)) {
            session_destroy();
            die(error_page("Error conectando a la BD", "<p>Ha ocurrido un error conectandose a la BD: $conexion</p>"));
        }

        // Busco al usuario
        $resultado = buscarExistente($conexion, $_POST["usuario"], "lector", "usuarios");
        if (is_string($resultado)) {
            session_destroy();
            die(error_page("Error buscando a la BD", "<p>Ha ocurrido un error buscando en la BD: $resultado</p>"));
        }
        if (mysqli_num_rows($resultado) > 0) {
            $tupla = mysqli_fetch_assoc($resultado);
            // Si están bien el usuario y la contraseña lo mando a su página
            if (md5($_POST["psw"]) == $tupla["clave"]) {
                $_SESSION["user"] = $_POST["usuario"];
                $_SESSION["clave"] = $tupla["clave"];
                $_SESSION["tipo"] = $tupla["tipo"];
                $_SESSION["ultMov"] = time();
                mysqli_free_result($resultado);
                mysqli_close($conexion);
                header("Location: index.php");
                exit();
            }
        }
        $error_form = !$error_form;
        mysqli_free_result($resultado);
    }
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicio</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td {
            padding: 1rem;
            text-align: center;
        }

        img {
            width: 100%;
            height: auto;
            border: 1px solid black;
        }

        .error {
            color: red;
        }

        .enlace {
            background-color: white;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
            border: none;
        }

        .linea {
            display: inline;
        }
    </style>
</head>

<body>
    <h2>Librería</h2>
    <?php
    if (isset($_SESSION["user"])) {
        print "<p class='linea'>Bienvenido " . $datos_lector["lector"] . " - <form class='linea' action='index.php' method='post' ><button name='btnSalir' class='enlace'>Salir</button></form></p>";
    } else {
    ?>
        <form action="index.php" method="post">
            <p>
                <label for="usuario">Usuario:</label>
                <input type="text" value="<?php if (isset($_POST["btnEntrar"])) print $_POST["usuario"] ?>" name="usuario" id="usuario" maxlength="15">
                <?php
                if (isset($_POST["btnEntrar"]) && $error_form) {
                    if ($_POST["usuario"] == "") {
                        print "<span class='error'> * Campo vacío * </span>";
                    } else {
                        print "<span class='error'> * Usuario o contraseña incorrecto * </span>";
                    }
                }
                ?>
            </p>
            <p>
                <label for="psw">Contraseña:</label>
                <input type="password" name="psw" id="psw" maxlength="20">
                <?php
                if (isset($_POST["btnEntrar"]) && $_POST["psw"] == "") {
                    print "<span class='error'> * Campo vacío * </span>";
                }
                ?>
            </p>
            <button name="btnEntrar">Entrar</button>
        </form>
    <?php
    }
    ?>

    <h3>Listado de Libros</h3>
    <?php
    // Busco los libros que haya en la BD
    if (!isset($conexion)) {
        $conexion = conectarBD();
        if (is_string($conexion)) {
            session_destroy();
            die("<p>Ha ocurrido un error conectandose a la BD: $conexion</p></body></html>");
        }
    }

    try {
        $consulta = "select * from libros";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (mysqli_sql_exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die("<p>Ha ocurrido un error buscando en la BD: " . $e->getMessage() . "</p></body></html>");
    }
    if (mysqli_num_rows($resultado) > 0) {
        print "<table>";
        $contador = 1;
        print "<tr>";
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            print "<td>";
            print "<img src='Images/" . $tupla["portada"] . "' alt='" . $tupla["titulo"] . "' title='" . $tupla["titulo"] . "' />";
            print "<p>" . $tupla["titulo"] . " - " . $tupla["precio"] . " €</p>";
            print "</td>";

            // Cada 3 libros hago una fila nueva
            if ($contador % 3 === 0) {
                print "</tr>";
                print "<tr>";
            }
            $contador++;
        }
        // Cuando acabe cierro el tr que dejo abierto
        print "</tr>";
        print "</table>";
    } else {
        print "<p>Actualmente no disponemos de libros en nuestra base de datos.</p>";
    }
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>

</body>

</html>