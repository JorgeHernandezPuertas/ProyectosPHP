<?php
    if (isset($_POST["btnBorrar"])){
        unset($_POST); // El unset() elimina la variable que le pongas (Esta opción es mejor)
        // Otra forma es:
        // header("Location: index.php")
        // exit;
    }

    $error_form = false;

    function Letra_NIF($dni){
        return substr("TRWAGMYFPDXBNJZSQVHLCKEO", substr($dni, 0, 8) % 23, 1);
    }

    function dni_valido($dni){
        if (strtoupper(substr($dni, -1)) == Letra_NIF($dni)){
            return true;
        } else {
            return false;
        }
    }

    if (isset($_POST["btnEnviar"])){ // Compruebo errores
        $error_nombre = $_POST["nombre"] == "";
        $error_apellidos = $_POST["apellidos"] == "";
        $error_contra = $_POST["contra"] == "";
        $error_sexo = !isset($_POST["sexo"]);
        $error_comentarios = $_POST["comentarios"] == "";
        $error_dni_vacio = $_POST["dni"] == "";
        $error_formato_dni = !preg_match("/^\d{8}([A-Z]||[a-z])$/", $_POST["dni"]);
        $error_dni = $error_dni_vacio || $error_formato_dni || !dni_valido($_POST["dni"]);
        

        $error_subir_imagen = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"];
        if (!$error_subir_imagen){
            $error_tipo = !getimagesize($_FILES["archivo"]["tmp_name"]);
            $error_tam = $_FILES["archivo"]["size"] > 500 * 1024;
            $error_imagen = $error_tipo || $error_tam;
        }

        if ($_FILES["archivo"]["name"] != ""){
            $error_form = $error_nombre || $error_apellidos || $error_contra
            || $error_sexo || $error_comentarios || $error_dni || $error_imagen;
        } else {
            $error_form = $error_nombre || $error_apellidos || $error_contra
        || $error_sexo || $error_comentarios || $error_dni;
        }

    }

    if (isset($_POST["btnEnviar"]) && !$error_form){
        require "vistas/vista_respuesta.php";
    } else {
        require "vistas/vista_formulario.php";
    }
