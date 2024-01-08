<?php
session_name("sesiones05_1");
session_start();

if (isset($_POST["accion"])) {
    switch ($_POST["accion"]) {
        case 'arriba':
            $_SESSION["y"] -= 20;
            if ($_SESSION["y"] < -200){
                $_SESSION["y"] = 200;
            }
            break;
        case 'izquierda':
            $_SESSION["x"] -= 20;
            if ($_SESSION["x"] < -200){
                $_SESSION["x"] = 200;
            }
            break;
        case 'derecha':
            $_SESSION["x"] += 20;
            if ($_SESSION["x"] > 200){
                $_SESSION["x"] = -200;
            }
            break;
        case 'abajo':
            $_SESSION["y"] += 20;
            if ($_SESSION["y"] > 200){
                $_SESSION["y"] = -200;
            }
            break;
        default: // Caso de boton de reset
            session_destroy();
            break;
    }
}

header("Location: sesiones05_1.php");
