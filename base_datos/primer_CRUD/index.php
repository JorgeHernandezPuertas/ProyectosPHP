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
    </style>
</head>

<body>
    <h1>Listado de los usuarios</h1>
    <?php
    define("HOST", "localhost");
    define("USER", "jose");
    define("PWD", "josefa");
    define("BD", "bd_foro");
    try {
        $conexion = mysqli_connect(HOST, USER, PWD, BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (mysqli_sql_exception $e) {
        die("<p>No se ha podido conectar a la base de datos: " . $e->getMessage() . "</p></body></html>");
    }

    $consulta = "select nombre from usuarios";

    try {
        $resultado = mysqli_query($conexion, $consulta);
    } catch (mysqli_sql_exception $e) {
        mysqli_close($conexion);
        die("<p>Ha habido un error realizando la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    $nombres = mysqli_fetch_all($resultado);
    mysqli_close($conexion);

    print "<table><tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";
    foreach ($nombres as $v) {
        print "<tr><td><a href='#'>" . $v[0] . "</a></td><td><img src='images/borrar.png' alt='Imagen de una cruz' width='50' title='Borrar usuario' ></td><td><img src='images/modificar.png' alt='Imagen de un lapiz' width='50' title='Editar usuario' ></td></tr>";
    }
    print "</table>";

    ?>

    <form action="usuario_nuevo.php" method="post" >
        <p>
            <button name="btnNuevoUsuario" id="boton-enviar" type="submit">Insertar nuevo usuario</button>
        </p>

    </form>

</body>

</html>