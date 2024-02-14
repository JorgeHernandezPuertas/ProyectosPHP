<?php
require "config_bd.php";
session_name("examen_horarios_sw");

// Función para logearse
function login($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => $e->getMessage());
    }

    try {
        $consulta = "select * from usuarios where usuario = ? and clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        return array("error" => $e->getMessage());
    }

    if ($sentencia->rowCount() === 0) {
        return array("mensaje" => "el usuario no se encuentra registrado en la BD");
    }

    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

    // Le creo su sesión en la API a este usuario, guardo los datos que me interesan y devuelvo el id de su sesión como token
    session_start();
    $_SESSION["usuario"] = $usuario["usuario"];
    $_SESSION["clave"] = $usuario["clave"];
    $_SESSION["tipo"] = $usuario["tipo"];
    $api_session = session_id();

    return array("usuario" => $usuario, "api_session" => $api_session);
}

// Función para comprobar si está logeado
function logueado($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => $e->getMessage());
    }

    try {
        $consulta = "select * from usuarios where usuario = ? and clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        return array("error" => $e->getMessage());
    }

    if ($sentencia->rowCount() === 0) return array("mensaje" => "El usuario no se encuentra en la BD");

    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

    return array("usuario" => $usuario, "logueado" => true);
}

function obtenerProfesores()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => $e->getMessage());
    }

    try {
        $consulta = "select * from usuarios where tipo <> 'admin'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        return array("error" => $e->getMessage());
    }

    $profesores = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    return array("profesores" => $profesores);
}

// Obtengo el horario completo de un profesor
function obtenerHorario($id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => $e->getMessage());
    }

    try {
        $consulta = "SELECT dia, hora, nombre, usuario FROM horario_lectivo JOIN grupos ON grupo = id_grupo WHERE horario_lectivo.usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        return array("error" => $e->getMessage());
    }

    $horario = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    return array("horario" => $horario);
}
