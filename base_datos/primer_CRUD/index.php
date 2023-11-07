<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica CRUD</title>
    <style>
        table,
        th,
        td,
        tr {
            border-collapse: collapse;
            border: 1px solid black;
            text-align: center;
        }

        th {
            background-color: #CCC;
        }

        td button {
            cursor: pointer;
            background-color: white;
            border: none;
        }

        .enlace {
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Listado de los usuarios</h1>
    <?php

    try {
        require "constantes_conexion.php";
        $conexion = mysqli_connect(HOST, USER, PWD, BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (mysqli_sql_exception $e) {
        die("<p>No se ha podido conectar a la base de datos: " . $e->getMessage() . "</p></body></html>");
    }

    $consulta = "select * from usuarios";

    try {
        $resultado = mysqli_query($conexion, $consulta);
    } catch (mysqli_sql_exception $e) {
        mysqli_close($conexion);
        die("<p>Ha habido un error realizando la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    $usuarios = mysqli_fetch_all($resultado);
    mysqli_free_result($resultado);


    print "<table><tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";
    foreach ($usuarios as $v) {
        print "<tr>
        <td>
        <form  action='index.php' method='post'>
        <button class='enlace' type='submit' name='btnDetalle' value='" . $v[0] . "' >
        " . $v[1] . "
        </button>
        </form>
        </td>
        <td>
        <form  action='index.php' method='post'>
        <button type='submit' name='btnBorrar' value='" . $v[0] . "' >
        <img src='images/borrar.png' alt='Imagen de una cruz' width='50' title='Borrar usuario' >
        </form>
        </td>
        </button>
        <td>
        <form  action='index.php' method='post'>
        <button type='submit' name='btnEditar' value='" . $v[0] . "' >
        <img src='images/modificar.png' alt='Imagen de un lapiz' width='50' title='Editar usuario' >
        </button>
        </form>
        </td>
        </tr>";
    }
    print "</table>";

    if (isset($_POST["btnDetalle"])) {
        // Código para listar detalles

        print "<h3>Detalles del usuario con id: " . $_POST["btnDetalle"] . "</h3>";

        try {
            $consulta = "select * from usuarios where id_usuario='" . $_POST["btnDetalle"] . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (mysqli_sql_exception $e) {
            mysqli_close($conexion);
            die("<p>Ha habido un error realizando la consulta: " . $e->getMessage() . "</p></body></html>");
        }


        if (mysqli_num_rows($resultado) > 0) { // Controlamos el error de si ha sido borrado mientras tienes la página cargada
            $datos_usuario = mysqli_fetch_assoc($resultado);
            mysqli_free_result($resultado);
    
            print "<p><strong>Nombre:</strong> ".$datos_usuario["nombre"]."</p>";
            print "<p><strong>Usuario:</strong> ".$datos_usuario["usuario"]."</p>";
            print "<p><strong>Email:</strong> ".$datos_usuario["email"]."</p>";
        } else {
            print "<p>El usuario seleccionado ha sido eliminado de la base de datos</p>";
        }

        mysqli_close($conexion);
    ?>
        <form action="index.php">
            <button type="submit">Volver</button>
        </form>
    <?php
    } else if (isset($_POST["btnBorrar"])) {
        // Código para borrar

    } else if (isset($_POST["btnEditar"])) {
        // Código para editar

    } else {
    ?>
        <form action="usuario_nuevo.php" method="post">
            <p>
                <button name="btnNuevoUsuario" id="boton-enviar" type="submit">Insertar nuevo usuario</button>
            </p>
        </form>
    <?php
    }
    ?>




</body>

</html>