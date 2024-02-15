<?php
require "config_bd.php";

function conexion_pdo()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

        $respuesta["mensaje"] = "Conexi&oacute;n a la BD realizada con &eacute;xito";

        $conexion = null;
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    return $respuesta;
}

function login($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Imposible conectar:" . $e->getMessage());
    }

    try {
        $consulta = "select * from usuarios where usuario = ? and clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error en la consulta:" . $e->getMessage());
    }

    if ($sentencia->rowCount() === 0) {
        return array("mensaje" => "Usuario no se encuentra registrado en la BD");
    }

    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

    session_name("Examen23-24_SW_API");
    session_start();
    $api_session = session_id();
    $_SESSION["usuario"] = $usuario["usuario"];
    $_SESSION["clave"] = $usuario["clave"];
    $_SESSION["tipo"] = $usuario["tipo"];

    return array("usuario" => $usuario, "api_session" => $api_session);
}

function logueado($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Error conectando:" . $e->getMessage());
    }

    try {
        $consulta = "select * from usuarios where usuario = ? and clave = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error en la consulta:" . $e->getMessage());
    }

    if ($sentencia->rowCount() === 0) {
        return array("mensaje" => "Usuario no se encuentra registrado en la BD");
    }

    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

    return array("usuario" => $usuario);
}

function obtenerAlumnos()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Error conectando:" . $e->getMessage());
    }

    try {
        $consulta = "select * from usuarios where tipo = 'alumno'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error en la consulta:" . $e->getMessage());
    }

    $alumnos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    return array("alumnos" => $alumnos);
}

function obtenerAsignaturasEvaluadas($cod_alu)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Error conectando:" . $e->getMessage());
    }

    try {

        $consulta = "select notas.cod_asig, denominacion, nota from notas join asignaturas on notas.cod_asig = asignaturas.cod_asig where cod_usu = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_alu]);
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error en la consulta:" . $e->getMessage());
    }

    $notas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    return array("notas" => $notas);
}

function obtenerAsignaturasNoEvaluadas($cod_alu)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Error conectando:" . $e->getMessage());
    }

    try {

        $consulta = "select * from asignaturas where asignaturas.cod_asig not in (select notas.cod_asig from notas join asignaturas on notas.cod_asig = asignaturas.cod_asig where cod_usu = ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_alu]);
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error en la consulta:" . $e->getMessage());
    }

    $notas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    return array("notas" => $notas);
}

function quitarNota($cod_alu, $cod_asig)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Error conectando:" . $e->getMessage());
    }

    try {

        $consulta = "delete from notas where cod_asig = ? and cod_usu = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_asig, $cod_alu]);
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error en la consulta:" . $e->getMessage());
    }

    return array("mensaje" => "Asignatura descalificada con éxito");
}

function ponerNota($cod_alu, $cod_asig)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Error conectando:" . $e->getMessage());
    }

    try {

        $consulta = "insert into notas (cod_asig, cod_usu, nota) values (?, ?, '0')";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_asig, $cod_alu]);
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error en la consulta:" . $e->getMessage());
    }

    return array("mensaje" => "Asignatura calificada con éxito");
}

function cambiarNota($cod_alu, $cod_asig, $nota)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return array("error" => "Error conectando:" . $e->getMessage());
    }

    try {

        $consulta = "update notas set nota = ? where cod_asig = ? and cod_usu = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$nota, $cod_asig, $cod_alu]);
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error en la consulta:" . $e->getMessage());
    }

    return array("mensaje" => "Asignatura calificada con éxito");
}
