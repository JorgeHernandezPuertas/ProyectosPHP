<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_foro");

function error_page($title, $body)
{
    $page = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>' . $body . '</body>
    </html>';
    return $page;
}

function repetido($conexion, $tabla, $columna, $valor)
{
    try {
        $consulta = "select * from " . $tabla . " where $columna=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]);
        $respuesta = $sentencia->rowCount() > 0;
    } catch (PDOException $e) {
        $respuesta = $e->getMessage();
    }
    $sentencia = null;
    return $respuesta;
}

function repetido_excluido($conexion, $tabla, $columna, $valor, $id)
{

    try {
        $consulta = "select * from " . $tabla . " where " . $columna . "= ? and id_usuario != ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor, $id]);
        $respuesta = $sentencia->rowCount() > 0;
    } catch (PDOException $e) {
        $respuesta =  $e->getMessage();
    }
    $sentencia = null;
    return $respuesta;
}
