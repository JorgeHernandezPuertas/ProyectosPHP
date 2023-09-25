<?php
    $error_form = false;

    if (isset($_POST["btnEnviar"])){ // Compruebo errores
        $error_nombre = $_POST["nombre"] == "";
        $error_sexo = !isset($_POST["sexo"]);
        $error_form = $error_nombre || $error_sexo;
    }

    if (isset($_POST["btnEnviar"]) && !$error_form){
        require "vistas/vista_respuesta.php";
    } else {
        require "vistas/vista_formulario.php";
    }
?>