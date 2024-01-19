<?php
// En esta parte no estoy logueado


// si le das al boton de entrar para iniciar sesión
if (isset($_POST["btnEntrar"])) {

    // mirara que no haya errores y si los hay los avisará en el formulario
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";
    $error_form = $error_usuario || $error_clave;

    // si no hay error en el formulario
    if (!$error_form) {
        // hace una consulta filtrando por el nombre y la contraseña
        try {
            $consulta = "select * from usuarios where lector='" . $_POST["usuario"] . "' and clave='" . md5($_POST["clave"]) . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Examen3 Curso 23-24", "<h1>Librería</h1><p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
        }

        // si hay mas de 0 tuplas (hay un usuario con ese nombre y esa contraseña)
        if (mysqli_num_rows($resultado) > 0) {
            // ---- crea las sesiones ----
            // la de usuario con el nombre del lector
            $_SESSION["usuario"] = $_POST["usuario"];
            // la de la clave con la clave del lector
            $_SESSION["clave"] = md5($_POST["clave"]);
            // y la de la ultima acción
            $_SESSION["ultima_accion"] = time();
            // guarda los datos del usuario
            $datos_usu_log = mysqli_fetch_assoc($resultado);
            mysqli_free_result($resultado);
            // cierra pq va ha cambiar de pagina con el header
            mysqli_close($conexion);

            // dependiendo del tipo te manda a un sitio diferente
            // mas qki
            // $ruta = $datos_usu_log["tipo"] == "normal" ?  "index.php" : "admin/gest_libros.php";
            //  header("Location:$ruta");
            if ($datos_usu_log["tipo"] == "normal") {
                header("Location:index.php");
            } else {
                header("Location:admin/gest_libros.php");
            }
            // sale pq puede leer la parte de abajo
            exit();
        } else {
            // si no hay resultados pone a true el error de usuario creado mas arriba en los errores
            // para asi poder reconocerlo en el if al poner los errores en el formulario
            $error_usuario = true;
        }

        mysqli_free_result($resultado);
    }
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen3 Curso 23-24</title>
    <style>
        img {
            height: 200px
        }

        div.fotos {
            text-align: center;
            width: 30%;
            margin-top: 2.5%;
            margin-left: 2.5%;
            float: left
        }

        .error {
            color: red;
        }

        .mensaje {
            color: blue;
        }
    </style>
</head>

<body>
    <!-- Creacion del formulario para el login -->
    <h1>Librería</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
            <?php
            if (isset($_POST["usuario"]) && $error_usuario)
                if ($_POST["usuario"] == "") {
                    echo "<span class='error'> Campo vacío</span>";
                } else {
                    // error en el login
                    echo "<span class='error'> Usuario/clave incorrectos</span>";
                }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST["clave"]) && $error_clave)
                echo "<span class='error'> Campo vacío</span>";
            ?>
        </p>
        <p>
            <button type="submit" name="btnEntrar">Entrar</button>
        </p>

        <!-- Acaba la parte del formulario y pasa a mostrar los libros -->
    </form>


    <?php
    // si existe la sesion de seguridad te muestra un mensaje
    if (isset($_SESSION["seguridad"])) {
        echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";
        session_destroy();
    }

    // cojo la vista que muestra los libros
    require "vistas/vista_libros.php";

    ?>
</body>

</html>