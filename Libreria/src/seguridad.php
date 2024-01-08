<?php

$conexion = conectarBD();
if (is_string($conexion)) {
    session_destroy();
    die(error_page("Error conectando a la BD", "<p>Ha ocurrido un error conectandose a la BD: $conexion</p>"));
}

$resultado = buscarExistente($conexion, $_SESSION["user"], "lector", "usuarios");
if (is_string($resultado)) {
    session_destroy();
    die(error_page("Error buscando en la BD", "<p>Ha ocurrido un error buscando en la BD: $resultado</p>"));
}

// Si el usuario ya buscado ya no está en la BD, es que ha sido baneado y le deslogeo
if (mysqli_num_rows($resultado) == 0){
    session_unset();
    $_SESSION["mensajeBaneado"] = "Usted ha sido baneado de nuestra página";
    header("Location: index.php");
    exit();
}

// Si ha excedido el tiempo de inactividad de la página, le deslogeo
$tiempo_actual = time();
if ($tiempo_actual - $_SESSION["ultMov"] > TIEMPO_INACTIVIDAD){
    session_unset();
    $_SESSION["mensajeInactivo"] = "Usted ha excedido el tiempo de inactividad de nuestra página";
    header("Location: index.php");
    exit();
}
// Refresco el último movimiento
$_SESSION["ultMov"] = time();
$datos_lector = mysqli_fetch_assoc($resultado);
mysqli_free_result($resultado);

?>