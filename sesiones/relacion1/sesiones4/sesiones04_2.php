<?php
session_name("sesiones04_1");
session_start();

if (isset($_POST["accion"])) {
    if ($_POST["accion"] == "izquierda") {
        $_SESSION["mov"] -= 20;
        if ($_SESSION["mov"] < -300) {
            $_SESSION["mov"] = 300;
        }
    } else if ($_POST["accion"] == "derecha") {
        $_SESSION["mov"] += 20;
        if ($_SESSION["mov"] > 300) {
            $_SESSION["mov"] = -300;
        }
    } else {
        session_destroy();
    }
}

header("Location: sesiones04_1.php");
exit;
