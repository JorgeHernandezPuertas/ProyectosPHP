<?php
session_name("sesiones02_1");
session_start();
if (isset($_POST["btnBorrar"])){
    session_destroy();
    header("Location: sesiones02_1.php");
    exit;
}

if (isset($_POST["nombre"]) && $_POST["nombre"] != ""){
    if (isset($_SESSION["mensaje"]))
        unset($_SESSION["mensaje"]);
    $_SESSION["nombre"] = $_POST["nombre"];
    header("Location: sesiones02_1.php");
    exit;
} else {
    if (isset($_SESSION["nombre"]))
        unset($_SESSION["nombre"]);
    $_SESSION["mensaje"] = "No has tecleado nada";
    header("Location: sesiones02_1.php");
    exit;
}
?>