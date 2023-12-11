<?php
// Control de baneo
// Conecto a la BD
$conexion = conectarBD();
if (is_string($conexion)) {
    session_destroy();
    die(error_page("Error conectando a la BD", "<h3>Ha ocurrido un error intentando conectar a la BD</h3><p>$conexion</p>"));
}

// Busco el usuario en cuestión
try {
    $consulta = "select * from usuarios where usuario='" . $_SESSION["user"] . "' and clave='" . $_SESSION["psw"] . "'";
    $resultado = mysqli_query($conexion, $consulta);
} catch (mysqli_sql_exception $e) {
    session_destroy();
    mysqli_close($conexion);
    die(error_page("Error consultando en la BD", "<h3>Ha ocurrido un error intentando consultar en la BD</h3><p>$e</p>"));
}

// Si está baneado
if (mysqli_num_rows($resultado) <= 0) {
    session_unset(); // Elimino todas las variables de sesión que tenia
    $_SESSION["seguridad"] = "No te encuentras registrado en la BD";
    mysqli_close($conexion);
    header("Location: index.php");
    exit();
}

// Aprovecho y me quedo con todos los datos del usuario logeado
$datos_usuario_logeado = mysqli_fetch_assoc($resultado);
mysqli_free_result($resultado);
mysqli_close($conexion);


// Control de inactividad
$tiempo_actual = time();
if ($tiempo_actual - $_SESSION["ultima_accion"] > TIEMPO_MAX) {
    session_unset();
    $_SESSION["tiempo_cumplido"] = "Su tiempo de sesión ha caducado";
    header("Location: index.php");
    exit();
}

// En caso de que haga una acción antes del límite de tiempo, renuevo el tiempo
$_SESSION["ultima_accion"] = time();
