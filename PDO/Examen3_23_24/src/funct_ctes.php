<?php

define("MINUTOS_INACT", 5);
// Host casa: 'localhost:3310' , Host clase: 'localhost'
define("SERVIDOR_BD", 'localhost');
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_libreria_exam");

// error page para mostrar el error cuando ocurre fuera de un html
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

// Con cuatro argumentos comprueba si hay repetidos cuándo insertamos
// Con seis argumentos comprueba si hay repetidos cuándo editamos
// devuelve un string, true o false (si es string es pq ha devuelto un error en la consulta)
function repetido($conexion, $tabla, $columna, $valor, $columna_clave = null, $valor_clave = null)
{
    try {
        if (isset($columna_clave)) {
            $consulta = "select * from $tabla where $columna=? and $columna_clave <> ?";
            $datos = [$valor, md5($valor_clave)];
        } else {
            $consulta = "select * from " . $tabla . " where " . $columna . "=?";
            $datos = [$valor];
        }
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta = $sentencia->rowCount() > 0;
        $sentencia = null;
    } catch (PDOException $e) {
        // si hay un error le pongo el mensaje del error y lo devuelvo
        $respuesta = $e->getMessage();
    }
    return $respuesta;
}
