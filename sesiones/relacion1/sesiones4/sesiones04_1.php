<?php
session_name("sesiones04_1");
session_start();
if (!isset($_SESSION["mov"])) {
    $_SESSION["mov"] = 0;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mover un punto a derecha e izquierda. Sesiones 04</title>
    <style>
        form{
            width: 600px;
        }
        .direcciones {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>MOVER UN PUNTO A DERECHA E IZQUIERDA</h1>
    <p>Haga click en los botones para mover el punto:</p>
    <form action="sesiones04_2.php" method="post">
        <p class="direcciones">
            <button type="submit" name="accion" value="izquierda" style="font-size: 60px;
line-height: 40px;">&#x261C;</button>
            <button type="submit" name="accion" value="derecha" style="font-size: 60px;
line-height: 40px;">&#x261E;</button>
        </p>

        <p><svg version="1.1" xmlns=http://www.w3.org/2000/svg width="600px" height="20px" viewbox="-300 0 600 20">
                <line x1="-300" y1="10" x2="300" y2="10" stroke="black" stroke-width="5" />
                <circle cx="<?php print $_SESSION["mov"] ?>" cy="10" r="8" fill="red" />
            </svg></p>
        <button type="submit" name="accion" value="reset">Volver al centro</button>
    </form>
</body>

</html>