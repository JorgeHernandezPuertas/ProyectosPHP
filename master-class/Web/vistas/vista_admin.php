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

        .izq {
            text-align: left;
            padding: .5rem;
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
    <h2>Hoy es <?php echo DIAS[date("w")] ?></h2>

    <?php
    // Obtenemos el horario
    $url = DIR_SERV . "/obtenerGuardias";
    $respuesta = consumir_servicios_REST($url, "GET", array("api_session" => $_SESSION["api_session"], "dia" => date("w")));
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die("<p>Error consumiendo el servicio: " . $url . "</p></body></html>");
    }

    if (isset($obj->error)) {
        session_destroy();
        die("<p>" . $obj->error . "</p></body></html>");
    }

    // En caso de éxito en la petición
    foreach ($obj->guardias as $tupla) {
        if (isset($guardia[$tupla->hora])) {
            array_push($guardia[$tupla->hora], [$tupla->id_usuario, $tupla->nombre]);
        } else {
            $guardia[$tupla->hora] = [[$tupla->id_usuario, $tupla->nombre]];
        }
    }

    echo "<table>";
    echo "<tr><th>Hora</th><th>Profesor de Guardia</th><th>Información del profesor</th></tr>";
    echo "<form action='index.php' method='post'>";
    for ($i = 1; $i <= count(HORAS); $i++) {
        echo "<tr>";
        echo "<th>" . HORAS[$i] . "</th>";
        echo "<td><ol>";

        foreach ($obj->guardias as $tupla) {
            if ($i === $tupla->hora) {
                print "<li><button type='submit' name='btnDetalles' class='enlace' value='" . $tupla->id_usuario . "'>" . $tupla->nombre . "</button></li>";
            }
        }
        /*
            foreach ($guardia[$i] as $tupla) {
                echo "<li><button type='submit' name='btnDetalles' class='enlace' value='" . $tupla[0] . "'>" . $tupla[1] . "</button></li>";
            }
        */
        echo "</ol></td>";
        echo "<td class='izq'>";
        if (isset($_POST["btnDetalles"])) {
            if ($i == 1) {

                $url = DIR_SERV . "/obtenerProfesor";
                $respuesta = consumir_servicios_REST($url, "GET", array("api_session" => $_SESSION["api_session"], "id_usuario" => $_POST["btnDetalles"]));
                $obj2 = json_decode($respuesta);
                if (!$obj2) {
                    session_destroy();
                    die("</td></tr></table><p>Error consumiendo el servicio: " . $url . "</p></body></html>");
                }

                if (isset($obj2->error)) {
                    session_destroy();
                    die("</td></tr></table><p>" . $obj2->error . "</p></body></html>");
                }
                if (isset($obj2->mensaje)) {
                    echo $obj2->mensaje;
                } else {
                    echo "<p><strong>Nombre: </strong>" . $obj2->usuario->nombre . "</p>";
                    echo "<p><strong>Usuario: </strong>" . $obj2->usuario->usuario . "</p>";
                    echo "<p><strong>Contraseña: </strong>" . $obj2->usuario->clave . "</p>";
                    echo "<p><strong>Email: </strong>" . ($obj2->usuario->email == '' ? 'Email no disponible.' : $obj2->usuario->email) . "</p>";
                }
            }
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</form>";
    echo "</table>";
    ?>
</body>

</html>