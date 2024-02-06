<?php
require "config_bd.php";

// a)
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

// b)
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

// d)
function obtenerLibros()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from libros";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error buscando en la BD: " . $e->getMessage());
    }

    $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    unset($conexion);
    unset($sentencia);

    return array("libros" => $resultado);
}

// e)
function crearLibro($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "insert into libros (referencia, titulo, autor, descripcion, precio, email) values (?, ?, ?, ?, ?, ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error insertando en la BD: " . $e->getMessage());
    }

    unset($conexion);
    unset($sentencia);

    return array("mensaje" => "Libro insertado correctamente en la BD");
}

// f)
function actualizarPortada($referencia, $portada)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "update libros set portada = ? where referencia = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$portada, $referencia]);
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error insertando en la BD: " . $e->getMessage());
    }

    unset($conexion);
    unset($sentencia);

    return array("mensaje" => "Portada cambiada correctamente en la BD");
}

// g)
function comprobarRepetido($tabla, $columna, $valor)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select $columna from $tabla where $columna = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]);
    } catch (PDOException $e) {
        unset($conexion);
        return array("error" => "Error insertando en la BD: " . $e->getMessage());
    }

    if ($sentencia->rowCount() > 0) {
        $repetido = true;
    } else {
        $repetido = false;
    }

    unset($conexion);
    unset($sentencia);

    return array("repetido" => $repetido);
}
