<?php
// host clase: localhost | host casa: localhost:3310
define("HOST", "localhost");
define("USER", "jose");
define("PSW", "josefa");
define("DB_NAME", "bd_tienda");

function login($usuario, $clave)
{
  try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {

    return array("mensaje_error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
  }

  try {
    $consulta = "select * from usuarios where usuario=? and clave=?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$usuario, $clave]);
  } catch (PDOException $e) {
    $sentencia = null;
    $conexion = null;
    return array("mensaje_error" => "No se ha podido realizar la consulta: " . $e->getMessage());
  }

  if ($sentencia->rowCount() > 0) {


    session_name("Api_foro_23_24_key");
    session_start();

    $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    $respuesta["api_session"] = session_id();

    $_SESSION["usuario"] = $usuario;
    $_SESSION["clave"] = $clave;
    $_SESSION["tipo"] = $respuesta["usuario"]["tipo"];
  } else
    $respuesta["mensaje"] = "El usuario no se encuentra en la BD";

  $sentencia = null;
  $conexion = null;
  return $respuesta;
}


function logueado($usuario, $clave)
{
  try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    return array("mensaje_error" => "No se ha podido conectar a la base de batos: " . $e->getMessage());
  }

  try {
    $consulta = "select * from usuarios where usuario=? and clave=?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$usuario, $clave]);
  } catch (PDOException $e) {
    $sentencia = null;
    $conexion = null;
    return array("mensaje_error" => "No se ha podido realizar la consulta: " . $e->getMessage());
  }

  if ($sentencia->rowCount() > 0) {
    $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
  } else
    $respuesta["mensaje"] = "El usuario no se encuentra en la BD";

  $sentencia = null;
  $conexion = null;
  return $respuesta;
}

function getAll()
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
    $consulta = "select * from producto";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
  } catch (PDOException $e) { // Si hay error lo devuelvo en un array asociativo
    $conexion = null;
    $sentencia = null;
    return array("mensaje_error" => "Ha ocurrido un error en el servidor buscando en la BD: " . $e->getMessage());
  }

  $respuesta = array("productos" => $sentencia->fetchAll(PDO::FETCH_ASSOC));
  $conexion = null;
  $sentencia = null;
  return $respuesta;
}

function getProductoById($id)
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    $conexion = null;
    $mensaje_error = "Ha ocurrido un error en el servidor conectando a la BD: " . $e->getMessage();
    return array("mensaje_error" => $mensaje_error);
  }

  try {
    $consulta = "select * from producto where cod=?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$id]);
  } catch (PDOException $e) { // Si hay error lo devuelvo en un array asociativo
    $conexion = null;
    $sentencia = null;
    return array("mensaje_error" => "Ha ocurrido un error en el servidor buscando en la BD: " . $e->getMessage());
  }

  $respuesta = array("producto" => $sentencia->fetch(PDO::FETCH_ASSOC));
  $conexion = null;
  $sentencia = null;
  return $respuesta;
}

function insertarProducto($datos)
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    $conexion = null;
    $mensaje_error = "Ha ocurrido un error en el servidor conectando a la BD: " . $e->getMessage();
    return array("mensaje_error" => $mensaje_error);
  }

  try {
    $consulta = "insert into producto (cod, nombre, nombre_corto, descripcion, PVP, familia) values (?, ?, ?, ?, ?, ?)";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute($datos);
  } catch (PDOException $e) { // Si hay error lo devuelvo en un array asociativo
    $conexion = null;
    $sentencia = null;
    return array("mensaje_error" => "Ha ocurrido un error en el servidor insertando en la BD: " . $e->getMessage());
  }

  $respuesta = array("mensaje" => "El producto se ha insertado con éxito");
  return $respuesta;
}

function actualizarProducto($datos)
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    $conexion = null;
    $mensaje_error = "Ha ocurrido un error en el servidor conectando a la BD: " . $e->getMessage();
    return array("mensaje_error" => $mensaje_error);
  }

  try {
    $consulta = "update producto set nombre=?, nombre_corto=?, descripcion=?, PVP=?, familia=? where cod=?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute($datos);
  } catch (PDOException $e) { // Si hay error lo devuelvo en un array asociativo
    $conexion = null;
    $sentencia = null;
    return array("mensaje_error" => "Ha ocurrido un error en el servidor actualizando en la BD: " . $e->getMessage());
  }

  if ($sentencia->rowCount() == 0) {
    $conexion = null;
    $sentencia = null;
    return array("mensaje" => "El producto que quiere actualizar no existe");
  }

  $conexion = null;
  $sentencia = null;
  $respuesta = array("mensaje" => "El producto se ha actualizado con correctamente");
  return $respuesta;
}

function borrarProducto($id)
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    $conexion = null;
    $mensaje_error = "Ha ocurrido un error en el servidor conectando a la BD: " . $e->getMessage();
    return array("mensaje_error" => $mensaje_error);
  }

  try {
    $consulta = "delete from producto where cod=?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$id]);
  } catch (PDOException $e) { // Si hay error lo devuelvo en un array asociativo
    $conexion = null;
    $sentencia = null;
    return array("mensaje_error" => "Ha ocurrido un error en el servidor eliminando en la BD: " . $e->getMessage());
  }

  if ($sentencia->rowCount() == 0) {
    $conexion = null;
    $sentencia = null;
    return array("mensaje" => "El producto que quiere borrar no existe");
  }

  $conexion = null;
  $sentencia = null;
  $respuesta = array("mensaje" => "El producto se ha eliminado correctamente");
  return $respuesta;
}

function getAllFamilias()
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
    $consulta = "select * from familia";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
  } catch (PDOException $e) { // Si hay error lo devuelvo en un array asociativo
    $conexion = null;
    $sentencia = null;
    return array("mensaje_error" => "Ha ocurrido un error en el servidor buscando en la BD: " . $e->getMessage());
  }

  $respuesta = array("familias" => $sentencia->fetchAll(PDO::FETCH_ASSOC));
  $conexion = null;
  $sentencia = null;
  return $respuesta;
}

function getFamilia($cod)
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
    $consulta = "select * from familia where cod = ?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$cod]);
  } catch (PDOException $e) { // Si hay error lo devuelvo en un array asociativo
    $conexion = null;
    $sentencia = null;
    return array("mensaje_error" => "Ha ocurrido un error en el servidor buscando en la BD: " . $e->getMessage());
  }

  $respuesta = array("familia" => $sentencia->fetch(PDO::FETCH_ASSOC));
  $conexion = null;
  $sentencia = null;
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
    $consulta = "select cod from $tabla where $col = ?";
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
    $consulta = "select cod from $tabla where $col= ? and $col_id <> ?";
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
