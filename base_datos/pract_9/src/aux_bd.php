<?php
// Creo constantes con los valores necesarios para conectarme a la BD
// Host casa: '127.0.0.1:3310' , Host clase: 'localhost'
//define("HOST", "127.0.0.1:3310");
define("HOST", "localhost");
define("USER", "jose");
define("PWD", "josefa");
define("BD", "bd_videoclub");

function error_page($title, $body)
{
    $page = '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>' . $body . '</body>
    </html>';
    return $page;
}

function conectarBD()
{
    try {
        $bd = mysqli_connect(HOST, USER, PWD, BD);
    } catch (mysqli_sql_exception $e) {
        return $e->getMessage();
    }
    return $bd;
}

function LetraNIF($dni)
{
    $valor = (int) ($dni / 23);
    $valor *= 23;
    $valor = $dni - $valor;
    $letras = "TRWAGMYFPDXBNJZSQVHLCKEO";
    $letraNif = substr($letras, $valor, 1);
    return $letraNif;
}

function repetido($conexion,$tabla,$columna,$valor)
{

    try{
        $consulta="select * from ".$tabla." where ".$columna."='".$valor."'";
        $resultado=mysqli_query($conexion, $consulta);
        $respuesta=mysqli_num_rows($resultado)>0;
        mysqli_free_result($resultado);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        $respuesta=error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>");
    }
    return $respuesta;
}

function repetido_excluido($conexion,$tabla,$columna,$valor, $id)
{

    try{
        $consulta="select * from $tabla where ".$columna."='".$valor."' and id_usuario != $id";
        $resultado=mysqli_query($conexion, $consulta);
        $respuesta=mysqli_num_rows($resultado)>0;
        mysqli_free_result($resultado);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        $respuesta=error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>");
    }
    return $respuesta;
}