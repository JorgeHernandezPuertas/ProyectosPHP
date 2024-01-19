<?php

// viki' or 1=1 or'1'='1
// poniendo eso se puede entrar sin la constraseña (poniendo el usuario que quieras)
// hace que te devueklva todos los usuarios, el primero es varo que no es admin por lo que entra a normal

session_name("examen3_23_24");
session_start();

// variables y funciones error_page y repetido
require "src/funct_ctes.php";


if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location:index.php");
    exit;
}


// Con esta conexion al inicio nos ahorramos tener que hacerla un monton de veces
try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    session_destroy();
    die(error_page("Examen3 Curso 23-24", "<h1>Librería</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
}


// Lo primero ha sido ver que dependiendo del usuario va a ver una cosa u otra y lo ha dividido
// de normal y admin todo se podría haber hecho en el mismo inde pero usamos el require para que se vea mejor
// Ya creadas las sesiones entramos aqui y comprobamos todo
if (isset($_SESSION["usuario"])) {

    // nos ayuda para reutilizar la misma seguridad en admin e index (pq varian las rutas)
    $salto = "index.php";

    // comprueba que el usuario no ha sido borrado y el tiempo de sesion
    require "src/seguridad.php";

    // --- esta parte creo que es en la que el normal entraba en la parte de admin sin ser admin cambiando la url ---
    // comprueba que se le está mandando al sitio en el que debe estar
    // normal al normal y admin al admin
    if ($datos_usuario_logueado["tipo"] == "normal") {
        require "vistas/vista_normal.php";
    } else {
        header("Location:admin/gest_libros.php");
        exit;
    }
} else {
    // la primera vez entra aqui pq no hay sesion iniciada
    require "vistas/vista_home.php";
}


// cierra la sesion despues de todo (en algunos errores dentro de las vistas tmb se cierra por si acaso)
$conexion = null;
