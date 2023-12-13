<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login</title>
    <style>
        .error {
            color: red;
        }

        .enlace {
            color: blue;
            background-color: inherit;
            border: none;
            cursor: pointer;
        }

        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 100%;
        }

        th {
            background-color: lightgray;
        }

        img {
            width: 100px;
            height: auto;
        }

        .tabla {
            background-color: inherit;
            border: none;
            cursor: pointer;
        }

        tr>td:last-child {
            border: none;
        }

        main {
            width: 70%;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <h2>PRIMER LOGIN - Vista Admin</h2>

    <?php
    print "<form action='index.php' method='post'>Bienvenido " . $_SESSION["user"] . " -<button class='enlace' name='btnSalir'>Salir</button></form>";

    print "<main>";
    require "vistas/vistaTabla.php";

    if (isset($_POST["btnDetalle"])) {
        require "vistas/vistaDetalle.php";
    }


    print "</main>";
    ?>
</body>

</html>