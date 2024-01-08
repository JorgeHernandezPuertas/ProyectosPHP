<?php
session_name("sesiones03_1");
session_start();
if (!isset($_SESSION["numero"])){
    $_SESSION["numero"] = 0;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir y bajar número. Sesiones 3</title>
</head>

<body>
    <h1>SUBIR Y BAJAR NÚMERO</h1>
    <p>Haga click en los botones para modificar el valor:</p>
    <form action="sesiones03_2.php" method="post">
        <p><button type="submit" name="restar">-</button> <?php print $_SESSION["numero"] ?> <button type="submit" name="sumar">+</button></p>
        <button type="submit" name="btnReset">Poner a cero</button>
    </form>
</body>

</html>