
<?php 
    if (isset($_POST["btnEnviar"])){
        $error_fichero_vacio = $_FILES["archivo"]["name"] == "" || $_FILES["archivo"]["error"];
        if (!$error_fichero_vacio){
            $error_fichero_tipo = !getimagesize($_FILES["archivo"]["tmp_name"]);
        }
        $error_fichero_tam = $_FILES["archivo"]["size"] > 500*1024; // El size de $_FILES viene en bytes
        $error_fichero = $error_fichero_vacio || $error_fichero_tipo || $error_fichero_tam;
    }


    if (isset($_POST["btnEnviar"]) && !$error_fichero){
        require "vistas/vista_subido.php";
    } else {
        require "vistas/vista_formulario.php";
    }
    ?>

