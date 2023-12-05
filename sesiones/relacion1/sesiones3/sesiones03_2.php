<?php
session_name("sesiones03_1");
session_start();

if (isset($_POST["btnReset"])){
    session_destroy();
}

if (isset($_POST["sumar"])){
    $_SESSION["numero"]++;
}

if (isset($_POST["restar"])){
    $_SESSION["numero"]--;
}

header("Location: sesiones03_1.php");
    exit;
?>