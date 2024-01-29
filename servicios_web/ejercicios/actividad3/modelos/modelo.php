<?php
// host clase: localhost | host casa: localhost:3310
define("HOST", "localhost");
define("USER", "jose");
define("PSW", "josefa");
define("DB_NAME", "bd_foro");

function getAllUsers()
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    return array("error" => "Error conectando a la DB: " . $e->getMessage());
  }

  try {
    $consulta = "select * from usuarios";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
  } catch (PDOException $e) {
    unset($conexion);
    return array("error" => "Error buscando en la DB: " . $e->getMessage());
  }

  return array("usuarios" => $sentencia->fetchAll(PDO::FETCH_ASSOC));
}

function insertUser($datos)
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    return array("error" => "Error conectando a la DB: " . $e->getMessage());
  }

  try {
    $consulta = "insert into usuarios (nombre, usuario, clave, email) values (?, ?, ?, ?)";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute($datos);
  } catch (PDOException $e) {
    unset($conexion);
    return array("error" => "Error insertando en la DB: " . $e->getMessage());
  }

  return array("ult_id" => $sentencia->fetch(PDO::FETCH_ASSOC)->id_usuario);
}

function checkLogin($datos)
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    return array("error" => "Error conectando a la DB: " . $e->getMessage());
  }

  try {
    $consulta = "select * from usuarios where usuario = ? and clave = ?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute($datos);
  } catch (PDOException $e) {
    unset($conexion);
    return array("error" => "Error buscando en la DB: " . $e->getMessage());
  }

  if ($sentencia->rowCount() === 0) return array("mensaje" => $datos["usuario"] . " no se encuentra registrado en la DB");

  return array("usuario" => $sentencia->fetch(PDO::FETCH_ASSOC));
}

function updateUser($datos)
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    return array("error" => "Error conectando a la DB: " . $e->getMessage());
  }

  try {
    $consulta = "update usuarios SET nombre = ?, usuario = ?, clave = ?, email = ? where id_usuario = ?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute($datos);
  } catch (PDOException $e) {
    unset($conexion);
    return array("error" => "Error insertando en la DB: " . $e->getMessage());
  }
}
