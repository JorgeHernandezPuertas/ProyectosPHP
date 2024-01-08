<?php
define("HOST", "localhost");
define("USER", "jose");
define("PSW", "josefa");
define("BD", "bd_libreria_exam");

define("TIEMPO_INACTIVIDAD", 120);

function error_page($title, $body)
{
    $html = '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>' . $title . '</title></head>';
    $html .= '<body>' . $body . '</body></html>';
    return $html;
}

function conectarBD(){
    try{
        $conexion = mysqli_connect(HOST, USER, PSW, BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (mysqli_sql_exception $e){
        return $e -> getMessage();
    }
    return $conexion;
}

function buscarExistente($conexion, $buscado, $campo, $tabla){
    try{
        $consulta = "select * from $tabla where $campo='$buscado'";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (mysqli_sql_exception $e){
        return $e -> getMessage();
    }
    return $resultado;
}

?>