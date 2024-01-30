<?php
// host clase: localhost | host casa: localhost:3310
define("HOST", "localhost");
define("USER", "jose");
define("PSW", "josefa");
define("DB_NAME", "bd_foro2");

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

  $respuesta = array("usuarios" => $sentencia->fetchAll(PDO::FETCH_ASSOC));
  unset($conexion);
  unset($sentencia);
  return $respuesta;
}

function getUser($id)
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    return array("error" => "Error conectando a la DB: " . $e->getMessage());
  }

  try {
    $consulta = "select * from usuarios where id_usuario = ?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$id]);
  } catch (PDOException $e) {
    unset($conexion);
    return array("error" => "Error buscando en la DB: " . $e->getMessage());
  }

  if ($sentencia->rowCount() === 0) {
    $respuesta = array("mensaje_error" => "El usuario no se encuentra en la DB");
    unset($conexion);
    unset($sentencia);
    return $respuesta;
  }

  $respuesta = array("usuario" => $sentencia->fetch(PDO::FETCH_ASSOC));
  unset($conexion);
  unset($sentencia);
  return $respuesta;
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
  // El lastInsertId() es un método de conexión, no de resultado
  $respuesta = array("ult_id" => $conexion->lastInsertId());
  unset($conexion);
  unset($sentencia);
  return $respuesta;
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

  if ($sentencia->rowCount() === 0) {
    $respuesta = array("mensaje" => $datos["usuario"] . " no se encuentra registrado en la DB");
    unset($conexion);
    unset($sentencia);
    return $respuesta;
  }

  $respuesta = array("usuario" => $sentencia->fetch(PDO::FETCH_ASSOC));
  unset($conexion);
  unset($sentencia);
  return $respuesta;
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
    return array("error" => "Error modificando en la DB: " . $e->getMessage());
  }

  if ($sentencia->rowCount() === 0) {
    $respuesta = array("mensaje_error" => "El usuario " . end($datos) . " no existe en la DB");
    unset($conexion);
    unset($sentencia);
    return $respuesta;
  }

  $respuesta = array("mensaje" => "El usuario " . end($datos) . " ha sido actualizado con éxito");
  unset($conexion);
  unset($sentencia);
  return $respuesta;
}

function deleteUser($id)
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    return array("error" => "Error conectando a la DB: " . $e->getMessage());
  }

  try {
    $consulta = "delete from usuarios where id_usuario = ?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$id]);
  } catch (PDOException $e) {
    unset($conexion);
    return array("error" => "Error eliminando en la DB: " . $e->getMessage());
  }

  $respuesta = array("mensaje" => "El usuario $id ha sido borrado con éxito");
  unset($conexion);
  unset($sentencia);
  return $respuesta;
}

function buscar_repetido($tabla, $col, $valor)
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    $conexion = null;
    $mensaje_error = "Ha ocurrido un error en el servidor conectando a la BD: " . $e->getMessage();
    return array("mensaje_error" => $mensaje_error);
  }

  // Hago la búsqueda
  try {
    $consulta = "select id_usuario from $tabla where $col = ?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$valor]);
  } catch (PDOException $e) { // Si hay error lo devuelvo en un array asociativo
    $conexion = null;
    $sentencia = null;
    return array("mensaje_error" => "Ha ocurrido un error en el servidor buscando en la BD: " . $e->getMessage());
  }

  if ($sentencia->rowCount() > 0) {
    $respuesta = array("repetido" => true);
  } else {
    $respuesta = array("repetido" => false);
  }

  $conexion = null;
  $sentencia = null;
  return $respuesta;
}

function buscar_valor_repetido($tabla, $col, $valor, $col_id, $valor_id)
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    $conexion = null;
    $mensaje_error = "Ha ocurrido un error en el servidor conectando a la BD: " . $e->getMessage();
    return array("mensaje_error" => $mensaje_error);
  }

  // Hago la búsqueda
  try {
    $consulta = "select id_usuario from $tabla where $col= ? and $col_id <> ?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$valor, $valor_id]);
  } catch (PDOException $e) { // Si hay error lo devuelvo en un array asociativo
    $conexion = null;
    $sentencia = null;
    return array("mensaje_error" => "Ha ocurrido un error en el servidor buscando en la BD: " . $e->getMessage());
  }

  if ($sentencia->rowCount() > 0) {
    $respuesta = array("repetido" => true);
  } else {
    $respuesta = array("repetido" => false);
  }

  $conexion = null;
  $sentencia = null;
  return $respuesta;
}
