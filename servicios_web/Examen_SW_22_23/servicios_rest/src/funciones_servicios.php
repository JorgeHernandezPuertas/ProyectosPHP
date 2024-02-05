<?php
require "config_bd.php";

function comprobarLogin($lector, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where lector = ? and clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$lector, $clave]);
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error buscando en la BD:" . $e->getMessage());
    }

    if ($sentencia->rowCount() === 0) {
        $respuesta = array("mensaje" => "El usuario no se encuentra registrado en la BD");
    } else {
        // Recupero la información del usuario que concuerde
        $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

        // Info de la sesión y la inicio para el token
        session_name("prueba-examen-sw-2022-2023");
        session_start();
        $api_session = session_id();
        $_SESSION["lector"] = $usuario->lector;
        $_SESSION["clave"] = $usuario->clave;
        $_SESSION["tipo"] = $usuario->tipo;

        // Pongo el formato de respuesta que me pide
        $respuesta = array("usuario" => $usuario, "api_session" => $api_session);
    }

    unset($conexion);
    unset($sentencia);
    return $respuesta;
}

function logueado($lector, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where lector = ? and clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$lector, $clave]);
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error buscando en la BD:" . $e->getMessage());
    }

    if ($sentencia->rowCount() === 0) {
        $respuesta = array("mensaje" => "El usuario no se encuentra registrado en la BD");
    } else {
        $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
        $respuesta = array("usuario" => $usuario);
    }

    unset($conexion);
    unset($sentencia);
    return $respuesta;
}
