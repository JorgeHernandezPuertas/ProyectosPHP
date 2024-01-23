<?php
define("HOST", "localhost");
define("USER", "jose");
define("PSW", "josefa");
define("DB_NAME", "bd_tienda");

function conectarDB()
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    $mensaje_error = "Ha ocurrido un error en el servidor conectando a la BD: " . $e->getMessage();
    return $mensaje_error;
  }
  return $conexion;
}

function getAll()
{
  /* Con la función conexión no funciona por alguna razón
  $conexion = conectarBD();
  
  Si la conexión falla devuelvo un array asociativo con un mensaje error
  if (is_string($conexion)) {
    return array("mensaje_error" => $conexion);
  }
*/
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

  $respuesta = array("producto" => $sentencia->fetchAll(PDO::FETCH_ASSOC));
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
