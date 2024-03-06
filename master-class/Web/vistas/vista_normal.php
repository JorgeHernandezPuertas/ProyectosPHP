<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesores 2 SW</title>
    <style>
        .enlinea {
            display: inline;
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        h3 {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
        }

        th,
        td,
        tr {
            border: 1px solid black;
            text-align: center;
        }

        th {
            background-color: #CCC;
        }
    </style>
</head>

<body>
    <h1>Profesores 2 SW</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_logueado->usuario; ?></strong> -
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <h2>Su horario</h2>
    <h3>Horario del Profesor: <?php echo $datos_usuario_logueado->nombre; ?></h3>

    <?php
    // Obtenemos el horario
    $url = DIR_SERV . "/obtenerHorario";
    $respuesta = consumir_servicios_REST($url, "GET", array("api_session" => $_SESSION["api_session"], "id_usuario" => $datos_usuario_logueado->id_usuario));
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");
    }

    if (isset($obj->error)) {
        session_destroy();
        die("<p>" . $obj->error . "</p></body></html>");
    }

    foreach ($obj->horario as $tupla) {
        if (isset($horarios[$tupla->hora][$tupla->dia])) {
            $horarios[$tupla->hora][$tupla->dia] .= " / " . $tupla->nombre;
        } else {
            $horarios[$tupla->hora][$tupla->dia] = $tupla->nombre;
        }
    }

    echo "<table>";
    echo "<tr><th></th>";
    for ($i = 1; $i <= count(DIAS); $i++) {
        echo "<th>" . DIAS[$i] . "</th>";
    }
    echo "</tr>";

    for ($i = 1; $i <= count(HORAS); $i++) {
        echo "<tr>";
        echo "<th>" . HORAS[$i] . "</th>";
        if ($i != 4) {
            for ($j = 1; $j <= count(DIAS); $j++) {

                echo "<td>";
                if (isset($horarios[$i][$j]))
                    echo $horarios[$i][$j];
                echo "</td>";
            }
        } else {
            echo "<td colspan='5'>RECREO</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    ?>
</body>

</html>