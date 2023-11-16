<?php
define("HOST", "localhost");
define("USER", "jose");
define("PWD", "josefa");
define("BD", "bd_foro");

function conectar_bd($mensaje_error) {
    try {
        $conexion = mysqli_connect(HOST, USER, PWD, BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (mysqli_sql_exception $e) {
        die("<p>No se ha podido conectar a la base de datos: " . $e->getMessage() . "</p> $mensaje_error");
    }
    return $conexion;
}

?>