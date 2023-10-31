<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría 1 - BD</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

        th {
            background-color: #CCC;
        }

    </style>
</head>

<body>
    <h2>Teoría 1 - BD</h2>
    <?php
    // Defino las constantes de mi usuario y host para conectarme
    define("HOST", "localhost");
    define("USER", "jose");
    define("PWD", "josefa");
    define("BD", "bd_teoria");

    // Sentencia para conectarse
    // Esta función esta actualizada y al dar error lanza una excepción, por lo que no se usa el @
    try {
        $conexion = mysqli_connect(HOST, USER, PWD, BD);
        mysqli_set_charset($conexion, "utf8"); // Codifico el charset para utf8
    } catch (mysqli_sql_exception $e) {
        die("<p>Ha ocurrido un error al intentar conectarse con la base de datos:\n " . $e->getMessage() . "</p></body></html>");
    }

    $consulta = "select * from t_alumnos";

    try {
        $resultado = mysqli_query($conexion, $consulta);
    } catch (mysqli_sql_exception $e) {
        mysqli_close($conexion); // Cierro la conexión antes de terminar el script
        die("<p>Imposible realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    $n_tuplas = mysqli_num_rows($resultado);
    print "<p>El número de filas obtenidas ha sido: $n_tuplas</p>";

    if ($n_tuplas != 0) {
        $i = 1;
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            print "<p>El $i alumno obtenido tiene el nombre: " . $tupla["nombre"] . "</p>";
            $i++;
        }
    }

    // mysqli_fetch_row() es como el fetch assoc, pero te devuelve un array normal, no asociativo, por lo que hay que saberse el orden
    // mysqli_fetch_array() trae un array con el row y el assoc, es decir, si hay 4 cols, trae un array de 8
    mysqli_data_seek($resultado, 0); // Este seek si funciona por tuplas y no por bytes como en ficheros

    $tupla = mysqli_fetch_object($resultado);
    print "<p>El primer alumno es:" . $tupla->nombre . "</p>";

    mysqli_data_seek($resultado, 0); // Devuelvo el puntero al inicio

    // Devuelve una matriz con todos las filas
    $tuplas = mysqli_fetch_all($resultado, 1); // El 1 es para tener el array asociativo
    print "<p>El primer alumno es: " . $tuplas[2]["nombre"] . "</p>";

    mysqli_data_seek($resultado, 0); // Devuelvo el puntero al inicio

    // Creo una la tabla de t_alumnos
    print "<table>";
    print "<caption><strong>Tabla de alumnos</strong> (como el profesor)</caption>";
    print "<tr><th>Código</th><th>Nombre</th><th>Teléfono</th><th>Cód. Postal</th></tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)){
        print "<tr>";
        foreach($tupla as $v){
            print "<td>$v</td>";
        }
        print "</tr>";
    }
    print "</table>";

    // Creo otra tabla para probar con el fetch_all
    mysqli_data_seek($resultado, 0); // Devuelvo el puntero al inicio
    $tuplas = mysqli_fetch_all($resultado, 1);
    print "<br><br><table>";
    print "<caption><strong>Tabla de alumnos</strong> (con el fecth_all)</caption>";
    print "<tr><th>Código</th><th>Nombre</th><th>Teléfono</th><th>Cód. Postal</th></tr>";
    foreach ($tuplas as $fila) { 
        print "<tr>";
       foreach ($fila as $col){
        print "<td>$col</td>";
       } 
       print "</tr>";
    }



    // Libero la memoria asociada al resultado para optimizar
    mysqli_free_result($resultado);

    mysqli_close($conexion); // Al acabar cierro la conexión a la BD
    ?>
</body>

</html>