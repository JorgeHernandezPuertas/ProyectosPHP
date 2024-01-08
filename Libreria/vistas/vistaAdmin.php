<?php
if (isset($_POST["btnBorrar"])) {
    $_SESSION["mensajeBorrado"] = "El libro con referencia " . $_POST["btnBorrar"] . " ha sido borrado con éxito.";
    header("Location: gest_libros.php");
    exit;
}
if (isset($_POST["btnEditar"])) {
    $_SESSION["mensajeEditado"] = "El libro con referencia " . $_POST["btnEditar"] . " ha sido editado con éxito.";
    header("Location: gest_libros.php");
    exit;
}

if (isset($_POST["btnAgregar"])) {
    $error_ref = $_POST["ref"] == "" || !is_numeric($_POST["ref"]) || $_POST["ref"] < 0;
    if (!$error_ref) {
        $resultado = buscarExistente($conexion, $_POST["ref"], "referencia", "libros");
        if (mysqli_num_rows($resultado) > 0) { // Si ya existe
            $error_ref = !$error_ref;
        }
        mysqli_free_result($resultado);
    }
    $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]) || $_POST["precio"] < 0;
    $error_portada = false;
    if ($_FILES["portada"]["name"] != "") {
        $error_portada = !getimagesize($_FILES["portada"]["tmp_name"]) || !explode(".", $_FILES["portada"]["name"]) || $_FILES["portada"]["size"] > 750 * 1024;
    }
    $error_form = $error_ref || $error_precio || $error_portada || $_POST["titulo"] == "" || $_POST["autor"] == "" || $_POST["desc"] == "";

    if (!$error_form) {
        // Si no hay error en el form, inserto el libro
        try {
            $consulta = "insert into libros (referencia, titulo, autor, descripcion, precio) values ('" . $_POST["referencia"] . "', '" . $_POST["titulo"] . "', '" . $_POST["autor"] . "', '" . $_POST["desc"] . "', '" . $_POST["precio"] . "')";
            mysqli_query($conexion, $consulta);
        } catch (mysqli_sql_exception $e) {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Error insertando en la BD", "<p>Ha ocurrido un error insertand en la BD " . $e->getMessage() . "</p>"));
        }

        // Si tiene foto la modifico y la inserto
        if ($_FILES["portada"]["name"] != "") {
            $partes = explode(".", $_FILES["portada"]["name"]);
            $ext = "." . end($partes);
            $nombrePortada = "img" . $_POST["referencia"] . $ext;
            @$var = move_uploaded_file($nombrePortada, "../Images");
            if (!$var) {
                mysqli_close($conexion);
                session_destroy();
                die(error_page("Error creando la imagen", "<p>Error creando la imagen en el servidor</p>"));
            }

            try{
                $consulta = "update libros set portada='$nombrePortada' where referencia='".$_POST["referencia"]."'";
                mysqli_query($conexion, $consulta);
            }catch (mysqli_sql_exception $e) {
                unlink("../Images/$nombrePortada");
                mysqli_close($conexion);
                session_destroy();
                die(error_page("Error modificando en la BD", "<p>Ha ocurrido un error modificando en la BD " . $e->getMessage() . "</p>"));
            }
        }

        mysqli_close($conexion);
        header("Location: gest_libros.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Libros</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
        }

        td,
        th {
            padding: 1rem;
            text-align: center;
            border: 1px solid black;
        }

        th {
            background-color: lightgray;
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

        .mensaje {
            color: blue;
        }
    </style>
</head>

<body>
    <h2>Librería</h2>
    <?php
    print "<p class=linea>Bienvenido " . $datos_lector["lector"] . " - <form class='linea' action='gest_libros.php' method='post' ><button name='btnSalir' class='enlace'>Salir</button></form></p>";
    if (isset($_SESSION["mensajeBorrado"])) {
        print "<p class='mensaje'>" . $_SESSION["mensajeBorrado"] . "</p>";
        unset($_SESSION["mensajeBorrado"]);
    }
    if (isset($_SESSION["mensajeEditado"])) {
        print "<p class='mensaje'>" . $_SESSION["mensajeEditado"] . "</p>";
        unset($_SESSION["mensajeEditado"]);
    }
    ?>
    <h3>Listado de los libros</h3>
    <?php
    try {
        $consulta = "select * from libros";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (mysqli_sql_exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die("<p>Ha ocurrido un error buscando en la BD: " . $e->getMessage() . "</p></body></html>");
    }

    print "<table>";
    print "<tr>";
    print "<th>Ref</th><th>Título</th><th>Acción</th>";
    print "</tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        print "<tr>";
        print "<td>" . $tupla["referencia"] . "</td><td>" . $tupla["titulo"] . "</td>";
        print "<td><form method='post'><button class='enlace' name='btnBorrar' value='" . $tupla["referencia"] . "'>Borrar</button> - <button class='enlace' name='btnEditar' value='" . $tupla["referencia"] . "'>Editar</button></form></td>";
        print "</tr>";
    }
    print "</table>";
    mysqli_free_result($resultado);
    ?>
    <h3>Agregar un nuevo libro</h3>
    <form action="gest_libros.php" method='post'>
        <p>
            <label for="ref">Referencia: </label>
            <input type="text" name="ref" id="ref" value='<?php if (isset($_POST["btnAgregar"])) print $_POST["red"] ?>'>
            <?php
            if (isset($_POST["btnAgregar"]) && $error_ref){
                if ($_POST["ref"] == ""){
                    print "<span class='error'> * Campo Vacío * </span>";
                } else if (!is_numeric($_POST["ref"])){
                    print "<span class='error'> * No has introducido un número * </span>";
                } else if ($_POST["ref"] < 0) {
                    print "<span class='error'> * Número no positivo * </span>";
                } else {
                    print "<span class='error'> * Referencia repetida * </span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="titulo">Título: </label>
            <input type="text" name="titulo" id="titulo" value='<?php if (isset($_POST["btnAgregar"])) print $_POST["titulo"] ?>'>
            <?php
            if (isset($_POST["btnAgregar"]) && $_POST["titulo"] == ""){
                print "<span class='error'> * Campo Vacío * </span>";
            }
            ?>
        </p>
        <p>
            <label for="autor">Autor: </label>
            <input type="text" name="autor" id="autor" value='<?php if (isset($_POST["btnAgregar"])) print $_POST["autor"] ?>'>
            <?php
            if (isset($_POST["btnAgregar"]) && $_POST["autor"] == ""){
                print "<span class='error'> * Campo Vacío * </span>";
            }
            ?>
        </p>
        <p>
            <label for="desc">Descripción: </label>
            <textarea name="desc" id="desc"><?php if (isset($_POST["btnAgregar"])) print $_POST["desc"] ?></textarea>
            <?php
            if (isset($_POST["btnAgregar"]) && $_POST["desc"] == ""){
                print "<span class='error'> * Campo Vacío * </span>";
            }
            ?>
        </p>
        <p>
            <label for="precio">Precio: </label>
            <input type="text" name="precio" id="precio" value='<?php if (isset($_POST["btnAgregar"])) print $_POST["precio"] ?>'>
            <?php
            if (isset($_POST["btnAgregar"]) && $error_precio){
                if ($_POST["precio"] == ""){
                    print "<span class='error'> * Campo Vacío * </span>";
                } else if (!is_numeric($_POST["precio"])){
                    print "<span class='error'> * No has introducido un número * </span>";
                } else if ($_POST["precio"] < 0) {
                    print "<span class='error'> * Número no positivo * </span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="portada">Portada: </label>
            <input type="file" name="portada" id="portada" accept="image/*">
            <?php
            if (isset($_POST["btnAgregar"]) && $error_portada){
                if (!getimagesize($_FILES["portada"]["tmp_name"])){
                    print "<span class='error'> * No es una imagen * </span>";
                } else if (!explode(".", $_FILES["portada"]["name"])){
                    print "<span class='error'> * No tiene extensión * </span>";
                } else if ($_FILES["portada"]["size"] > 750 * 1024) {
                    print "<span class='error'> * Supera el tamaño máximo * </span>";
                }
            }
            ?>
        </p>
        <button name="btnAgregar">Agregar</button>
    </form>
</body>

</html>