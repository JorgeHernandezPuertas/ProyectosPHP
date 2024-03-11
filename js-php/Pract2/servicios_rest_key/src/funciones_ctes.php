<?php
define("SERVIDOR_BD","localhost");
define("USUARIO_BD","jose");
define("CLAVE_BD","josefa");
define("NOMBRE_BD","bd_tienda");

function login($usuario,$clave)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("mensaje_error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario,$clave]);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("mensaje_error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

    if($sentencia->rowCount()>0)
    {
        
        
        session_name("Api_foro_23_24_key");
        session_start();

        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        $respuesta["api_session"]=session_id();
        
        $_SESSION["usuario"]=$usuario;
        $_SESSION["clave"]=$clave;
        $_SESSION["tipo"]=$respuesta["usuario"]["tipo"];


    }
    else
        $respuesta["mensaje"]="El usuario no se encuentra en la BD";

    $sentencia=null;
    $conexion=null;
    return $respuesta;

}


function logueado($usuario,$clave)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("mensaje_error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario,$clave]);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("mensaje_error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

    if($sentencia->rowCount()>0)
    {

        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);

        
    }
    else
        $respuesta["mensaje"]="El usuario no se encuentra en la BD";

    $sentencia=null;
    $conexion=null;
    return $respuesta;

}

function obtener_productos()
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("mensaje_error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        $consulta="select * from producto";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("mensaje_error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

    $respuesta["productos"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia=null;
    $conexion=null;
    return $respuesta;

}


function obtener_familia($codigo)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("mensaje_error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        $consulta="select * from familia where cod=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$codigo]);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("mensaje_error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

    if($sentencia->rowCount()>0)
        $respuesta["familia"]=$sentencia->fetch(PDO::FETCH_ASSOC);
    else
        $respuesta["mensaje"]="Lafamilia con cod: ".$codigo." no se encuentra en la BD";

    $sentencia=null;
    $conexion=null;
    return $respuesta;

}

function obtener_producto($codigo)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("mensaje_error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        $consulta="select * from producto where cod=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$codigo]);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("mensaje_error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

    if($sentencia->rowCount()>0)
        $respuesta["producto"]=$sentencia->fetch(PDO::FETCH_ASSOC);
    else
        $respuesta["mensaje"]="El producto con cod: ".$codigo." no se encuentra en la BD";

    $sentencia=null;
    $conexion=null;
    return $respuesta;

}


function insertar_producto($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("mensaje_error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        $consulta="insert into producto(cod,nombre,nombre_corto,descripcion,PVP,familia) values (?,?,?,?,?,?)";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("mensaje_error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

   
    $respuesta["mensaje"]="El producto se ha insertado correctamente";

    $sentencia=null;
    $conexion=null;
    return $respuesta;

}

function actualizar_producto($datos)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("mensaje_error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        $consulta="update producto set nombre=?, nombre_corto=?, descripcion=?, PVP=?, familia=? where cod=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("mensaje_error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

   
    if($sentencia->rowCount()>0)
        $respuesta["mensaje"]="El producto se ha actualizado correctamente";
    else
        $respuesta["mensaje"]="El producto no se encontraba en la BD";

    $sentencia=null;
    $conexion=null;
    return $respuesta;

}

function borrar_producto($codigo)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("mensaje_error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        $consulta="delete from producto where cod=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$codigo]);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("mensaje_error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

    if($sentencia->rowCount()>0)
        $respuesta["mensaje"]="El producto se ha borrado correctamente";
    else
        $respuesta["mensaje"]="El producto no se encontraba en la BD";

    $sentencia=null;
    $conexion=null;
    return $respuesta;

}


function obtener_familias()
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("mensaje_error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        $consulta="select * from familia";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute();
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("mensaje_error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

    $respuesta["familias"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia=null;
    $conexion=null;
    return $respuesta;

}


function repetido($tabla,$columna,$valor,$columna_id=null,$valor_id=null)
{
    try
    {
        $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch(PDOException $e)
    {
        
        return array("mensaje_error"=>"No se ha podido conectar a la base de batos: ".$e->getMessage());
    }
    try{
        if(isset($columna_id))
        {
            $consulta="select * from ".$tabla." where ".$columna."=? AND ".$columna_id."<>?";
            $datos=[$valor,$valor_id];
        }
        else
        {
            $consulta="select * from ".$tabla." where ".$columna."=?";
            $datos=[$valor];
        }
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute($datos);
    }
    catch(PDOException $e)
    {
        $sentencia=null;
        $conexion=null;
        return array("mensaje_error"=>"No se ha podido realizar la consulta: ".$e->getMessage());
    }

    $respuesta["repetido"]=($sentencia->rowCount())>0;
    $sentencia=null;
    $conexion=null;
    return $respuesta;

}


?>