<?php
// Traigo las funciones
require "src/funciones.php"; 

// Si pulsa resetear, borro los enviado
if (isset($_POST["btnReset"])){ 
unset($_POST); 
}

// Compruebo los errores
if (isset($_POST["btnEnviar"])){ 
    // Controlo los textos vacios
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    $error_password = $_POST["password"] == "";

    // Controlo dni
    $dni = strtoupper(trim($_POST["dni"]));
    $error_dni_vacio = $dni == "";
    $error_dni_formato = preg_match("/^\d{8}[A-Z]$/", $dni);
    $error_dni_letra = false;
    if ($error_dni_formato){
        $error_dni_letra = LetraNIF(substr($dni, 0, 8)) != substr($dni, -1);
    }
    $error_dni = $error_dni_vacio || $error_dni_formato || $error_dni_letra;

    $error_sexo = !isset($_POST["sexo"]);

    // Si se envia una foto
    $error_foto = false;
    if ($_FILES["imagen"]["name"] != ""){ 
        $error_tam = $_FILES["imagen"]["size"] < 500 * 1024;
        $error_tipo = !getimagesize($_FILES["imagen"]["tmp_name"]);
        $error_foto = $error_tam || $error_tipo;
    }

    $errores = $error_nombre || $error_usuario || $error_password || $error_dni || $error_sexo 
    || $error_foto;
}

// Envio a las diferentes vistas dependiendo de los errores
if (isset($_POST["btnEnviar"]) && $errores){ 
    require "vistas/vista_enviado.php";
} else {
    require "vistas/vista_formulario.php";
}

?>