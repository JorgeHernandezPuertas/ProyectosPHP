<?php
// coge los datos del usuario de la sesion
try {
    $consulta = "select * from usuarios where lector='" . $_SESSION["usuario"] . "' and clave='" . $_SESSION["clave"] . "'";
    $resultado = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    session_destroy();
    mysqli_close($conexion);
    die(error_page("Examen3 Curso 23-24", "<h1>Librería</h1><p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p>"));
}

// en el caso en el que no exista
if (mysqli_num_rows($resultado) <= 0) {

    mysqli_free_result($resultado);

    // cierra pq despues se hace un header
    mysqli_close($conexion);
    // unset te pone las cosas a null (destroy borra $_SESSION)
    session_unset();

    // crea la sesion de seguridad para poner mensajes de lo que pasa
    // en este caso al no haber resultados pero haber iniciado una vez
    // quiere decir que el usuario ha sido borrado
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";

    header("Location:" . $salto);
    exit;
}

// guardo los datos del usuario que se ha logueado otra vez?
$datos_usuario_logueado = mysqli_fetch_assoc($resultado);
mysqli_free_result($resultado);



// Ahora control de inactividad
// si el tiempo sin hacer nada han sido de mas de 5 min
if (time() - $_SESSION["ultima_accion"] > MINUTOS_INACT * 60) {
    mysqli_close($conexion);
    session_unset();
    // cambia el msj de seguridad por el de tiempo
    $_SESSION["seguridad"] = "Su tiempo de sesión ha caducado";

    header("Location:" . $salto);
    exit;
}

$_SESSION["ultima_accion"] = time();
