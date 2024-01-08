<?php
session_name("sesiones05_1");
session_start();

if (!isset($_SESSION["x"])) {
    $_SESSION["x"] = 0;
}

if (!isset($_SESSION["y"])) {
    $_SESSION["y"] = 0;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mover un punto en dos dimensiones. Sesiones 05</title>
    <style>
        div#caja {
            display: flex;
            flex-flow: wrap;
            justify-content: center;
            align-items: center;
        }

        div#caja>p {
            flex: 100%;
        }

        div#caja>div,
        div#caja>form {
            flex: 45% 0;
        }

        div#caja div#botonera {
            text-align: center;
            margin-bottom: 1rem;
        }

        div#caja div#botonera button {
            width: 5rem;
            height: 5rem;
            margin: 0;
        }

        div#caja div#botonera>div#centro {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <h1>MOVER UN PUNTO EN DOS DIMENSIONES</h1>
    <div id="caja">
        <p>Haga click en los botones para mover el punto:</p>
        <form action="sesiones05_2.php" method="post">
            <div id="botonera">
                <button type="submit" name="accion" value="arriba" style="font-size: 40px;">&#x1F446;</button>
                <div id="centro">
                    <button type="submit" name="accion" value="izquierda" style="font-size: 40px;">&#x1F448;</button>
                    <button type="submit" name="accion" value="reset">Volver al centro</button>
                    <button type="submit" name="accion" value="derecha" style="font-size: 40px;">&#x1F449;</button>
                </div>
                <button type="submit" name="accion" value="abajo" style="font-size: 40px;">&#x1F447;</button>
            </div>
        </form>
        <div id="mapa">
            <svg version="1.1" xmlns=http://www.w3.org/2000/svg width="400px" height="400px" viewbox="-200 -200 400 400">
                <line x1="-200" y1="-200" x2="200" y2="-200" stroke="black" stroke-width="5" />
                <line x1="-200" y1="-200" x2="-200" y2="200" stroke="black" stroke-width="5" />
                <line x1="200" y1="-200" x2="200" y2="200" stroke="black" stroke-width="5" />
                <line x1="-200" y1="200" x2="200" y2="200" stroke="black" stroke-width="5" />
                <circle cx="<?php print $_SESSION["x"] ?>" cy="<?php print $_SESSION["y"] ?>" r="8" fill="red" />
            </svg>
        </div>
    </div>
</body>

</html>