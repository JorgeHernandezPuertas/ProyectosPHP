<?php

// ¿Este apartado es solo para seguridad?

session_name("examen3_23_24");
session_start();

// variables y funciones error_page y repetido
require "../src/funct_ctes.php";

if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:../index.php");
    exit;
}

// si se ha iniciado sesion
if (isset($_SESSION["usuario"])) {

    $salto = "../index.php";

    // hace una conexion nueva ya que no esta en el index           (se abre aqui y se usa en la vista)
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        session_destroy();
        die(error_page("Examen3 Curso 23-24", "<h1>Librería</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }

    // comprueba que el usuario no ha sido borrado y el tiempo de sesion
    require "../src/seguridad.php";

    // comprueba que el lector esta donde debe estar
    if ($datos_usuario_logueado["tipo"] == "admin") {
        require "../vistas/vista_admin.php";
    } else {
        header("Location:../index.php");
        exit;
    }
} else {
    // si no esta la sesion creada te lleva al index
    header("Location:../index.php");
    exit();
}
