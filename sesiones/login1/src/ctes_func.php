<?php
// Creo constantes con los valores necesarios para conectarme a la BD
// Host casa: '127.0.0.1:3310' , Host clase: 'localhost'
//define("HOST", "127.0.0.1:3310");
define("HOST", "localhost");
define("USER", "jose");
define("PWD", "josefa");
define("BD", "bd_foro2");

// Defino el tiempo máximo (60 segundos en este caso)
define("TIEMPO_MAX", 60);

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
        mysqli_set_charset($bd, "utf8");
    } catch (mysqli_sql_exception $e) {
        return $e->getMessage();
    }
    return $bd;
}

