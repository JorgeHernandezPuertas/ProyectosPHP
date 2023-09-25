<?php
    if (isset($_POST["btnBorrar"])){
        unset($_POST); // El unset() elimina la variable que le pongas (Esta opción es mejor)
        // Otra forma es:
        // header("Location: index.php")
        // exit;
    }

    $error_form = false;

    if (isset($_POST["btnEnviar"])){ // Compruebo errores
        $error_nombre = $_POST["nombre"] == "";
        $error_apellidos = $_POST["apellidos"] == "";
        $error_contra = $_POST["contra"] == "";
        $error_sexo = !isset($_POST["sexo"]);
        $error_comentarios = $_POST["comentarios"] == "";
        $error_form = $error_nombre || $error_apellidos || $error_contra
        || $error_sexo || $error_comentarios;
    }

    if (isset($_POST["btnEnviar"]) && !$error_form){
        require "vistas/vista_respuesta.php";
    } else {
        require "vistas/vista_formulario.php";
    }
?>