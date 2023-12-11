<?php
session_name("Primer_login");
session_start();

require "src/ctes_func.php";

// Cuando intente logear
if (isset($_POST["btnLogin"])) {

    $error_form = $_POST["user"] == "" || $_POST["psw"] == "";

    if (!$error_form) {
        // Conecto a la BD
        $conexion = conectarBD();
        if (is_string($conexion)) {
            session_destroy();
            die(error_page("Error conectando a la BD", "<h3>Ha ocurrido un error intentando conectar a la BD</h3><p>$conexion</p>"));
        }

        // Busco el usuario en cuestión
        try {
            $consulta = "select usuario, clave, tipo from usuarios where usuario='" . $_POST["user"] . "' and clave='" . md5($_POST["psw"]) . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (mysqli_sql_exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Error consultando en la BD", "<h3>Ha ocurrido un error intentando consultar en la BD</h3><p>$e</p>"));
        }

        // Si existe ese usuario compruebo si está bien la contraseña
        $tuplas = mysqli_num_rows($resultado);
        if ($tuplas > 0) {
            $tupla = mysqli_fetch_assoc($resultado);
            if ($tupla["clave"] == md5($_POST["psw"])) { // Si la contraseña es correcta
                $_SESSION["user"] = $_POST["user"];
                $_SESSION["psw"] = md5($_POST["psw"]);
                $_SESSION["ultima_accion"] = time();
                $_SESSION["mensaje"] = "Te has logeado con éxito";

                mysqli_close($conexion);
                header("Location: index.php");
                exit();
            } else {
                // Si la contraseña es incorrecta
                $_SESSION["pswMal"] = "Contraseña incorrecta";
                $error_form = !$error_form;
            }
        } else {
            $error_form = !$error_form;
            $_SESSION["userMal"] = "El usuario introducido no existe";
        }
        mysqli_close($conexion);
    }
}
// Cuando salga de su cuenta
if (isset($_POST["btnSalir"])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Cuando esté baneado o borremos el usuario y siga con la sesión abierta
// SEGURIDAD
if (isset($_SESSION["user"])) { // Cuanto esta logeado
    
    require "src/seguridad.php";

    // Vistas si todo está bien
    if ($datos_usuario_logeado["tipo"] == "admin"){
        require "vistas/vistaAdmin.php";
    } else {
        require "vistas/vistaNormal.php";
    }
} else { // Cuando no está logeado
    if (isset($_SESSION["tiempo_cumplido"])){
        require "vistas/vistaTiempo.php";
    } else {
        require "vistas/vistaLogin.php";
    }
}

?>