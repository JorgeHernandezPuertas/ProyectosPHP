<?php
session_name("Primer_login_23_24");
session_start();
require "src/ctes_func.php";

// Botón salir que debe estar en cada una de las vistas logueadas
if(isset($_POST["btnSalir"]))
{
    session_destroy();
    header("Location:index.php");
    exit;
}

if(isset($_SESSION["usuario"]))// Por aquí estoy logueado
{
    require "src/seguridad.php";

    // He pasado los dos controles

    if($datos_usuario_logueado["tipo"]=="admin")
        require "vistas/vista_admin.php";
    else
        require "vistas/vista_normal.php";

    mysqli_close($conexion);

}
else
{
    require "vistas/vista_login.php";
}
