<?php
require "config_bd.php";

function login($usuario, $clave)
{
    // Conexión
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Imposible conectar:" . $e->getMessage());
    }

    // Consulta
    try {
        $consulta = "select * from usuarios where usuario = ? and clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "Imposible realizar la consulta:" . $e->getMessage());
    }

    if ($sentencia->rowCount() > 0) {
        // Si está en la bd, lo logueamos
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("Examen_SW_22_23");
        session_start();
        $_SESSION["usuario"] = $respuesta["usuario"]["usuario"];
        $_SESSION["clave"] = $respuesta["usuario"]["clave"];
        $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
        $respuesta["api_session"] = session_id();
    } else {
        // Si no le decimos que no está en la bd
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function logueado($usuario, $clave)
{
    // Conexión
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Imposible conectar:" . $e->getMessage());
    }

    // Consulta
    try {
        $consulta = "select * from usuarios where usuario = ? and clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "Imposible realizar la consulta:" . $e->getMessage());
    }

    if ($sentencia->rowCount() > 0) {
        // Si está en la bd, devolvemos los datos
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        // Si no le decimos que no está en la bd
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_horario($usuario)
{
    // Conexión
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Imposible conectar:" . $e->getMessage());
    }

    // Consulta
    try {
        $consulta = "select * from horario_lectivo,grupos  where grupo=id_grupo && usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "Imposible realizar la consulta:" . $e->getMessage());
    }
    // Devolvemos el horario
    $respuesta["horario"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_guardias($dia)
{
    // Conexión
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Imposible conectar:" . $e->getMessage());
    }

    // Consulta
    try {
        $consulta = "select usuarios.id_usuario, usuarios.nombre, dia, hora from usuarios,horario_lectivo  where id_usuario=horario_lectivo.usuario && horario_lectivo.grupo = '51' && dia = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "Imposible realizar la consulta:" . $e->getMessage());
    }
    // Devolvemos los guardias
    $respuesta["guardias"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function obtener_profesor($id_usuario)
{
    // Conexión
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Imposible conectar:" . $e->getMessage());
    }

    // Consulta
    try {
        $consulta = "select * from usuarios where id_usuario = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("error" => "Imposible realizar la consulta:" . $e->getMessage());
    }

    if ($sentencia->rowCount() > 0) {
        // Si está en la bd, devolvemos los datos
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        // Si no le decimos que no está en la bd
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
