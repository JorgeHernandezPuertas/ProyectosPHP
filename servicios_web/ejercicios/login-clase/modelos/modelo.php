<?php
// host clase: localhost | host casa: localhost:3310
define("HOST", "localhost");
define("USER", "jose");
define("PSW", "josefa");
define("DB_NAME", "bd_tienda");

function login($usuario, $clave)
{
  try {
    $conexion = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PSW, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  } catch (PDOException $e) {
    return array("mensaje_error" => "No se ha podido conectar a la base de datos: " . $e->getMessage());
  }

  try {
    $consulta = "select * from usuario where usuario = ? and clave = ?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$usuario, $clave]);
  } catch (PDOException $e) {
    unset($conexion);
    return array("mensaje_error" => "No se ha podido buscar en la base de datos: " . $e->getMessage());
  }

  if ($sentencia->rowCount() === 1) {
    return array("usuario" => $sentencia->fetch(PDO::FETCH_ASSOC));
  } else {
    return array("mensaje" => "El usuario o la contraseña no existen en la base de datos");
  }
}
