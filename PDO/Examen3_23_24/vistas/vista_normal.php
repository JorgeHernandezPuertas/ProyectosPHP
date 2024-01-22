<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen3 Curso 23-24</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

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
    </style>
</head>

<body>
    <!-- Se ve muy raro -->
    <h1>Librería (normal)</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_logueado["lector"]; ?></strong> -
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>

    <?php
    // vuelvo a hacer un listado de los libros en la parte del lector normal
    require "vistas/vista_libros.php";

    ?>
</body>

</html>