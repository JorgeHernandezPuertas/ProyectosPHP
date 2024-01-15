<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría PDO</title>
</head>
<body>
    <h1>Teoría PDO</h1>
    <?php
        define("SERVIDOR_BD","localhost");
        define("USUARIO_BD","jose");
        define("CLAVE_BD","josefa");
        define("NOMBRE_BD","bd_foro");
    
        /*
        try{
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");
        }
        catch(Exception $e)
        {
            die("<p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p></body></html>");
        }
        */

        
        try
        {
            $conexion=new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch(PDOException $e)
        {
            die("<p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p></body></html>");
        }
        
        echo "<p>Todo Bien</p>";

        /*
        
        $usuario="masantos76";
        $clave=md5("123456");

        
        try{
            $consulta="select * from usuarios where usuario='".$usuario."' and clave='".$clave."'";
            $resultado=mysqli_query($conexion, $consulta);
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
        }

        if(mysqli_num_rows($resultado)<=0)
        {
            echo "<p>No hay usuarios con esas credenciales en la BD</p>";
        }
        else
        {
            $tupla=mysqli_fetch_assoc($resultado);
            echo "<p>El nombre del usuario logueado es: <strong>".$tupla["nombre"]."</strong></p>";
        }
        mysqli_free_result($resultado);
        mysqli_close($conexion);

        */
        /*
        try{
            $consulta="select * from usuarios where usuario=? and clave=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$usuario,$clave]);
        }
        catch(PDOException $e)
        {
            $sentencia=null;
            $conexion=null;
            die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
        }

        if($sentencia->rowCount()<=0)
        {
            echo "<p>No hay usuarios con esas credenciales en la BD</p>";
        }
        else
        {
            $tupla=$sentencia->fetch(PDO::FETCH_ASSOC);//otras Ctes: PDO::FETCH_NUM, PDO::FETCH_OBJECT
            echo "<p>El nombre del usuario logueado es: <strong>".$tupla["nombre"]."</strong></p>";

        }
        $sentencia=null;
        $conexion=null;
        */
        /*
        try{
            $consulta="select * from usuarios";
            $resultado=mysqli_query($conexion, $consulta);
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
        }

        if(mysqli_num_rows($resultado)<=0)
        {
            echo "<p>No hay usuarios en la BD</p>";
        }
        else
        {
            while($tupla=mysqli_fetch_assoc($resultado))
            {
                echo "<p>El nombre del usuario es: <strong>".$tupla["nombre"]."</strong></p>";
            }
        }
        mysqli_free_result($resultado);
        mysqli_close($conexion);
        */

        /*
        try{
            $consulta="select * from usuarios";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute();
        }
        catch(PDOException $e)
        {
            $sentencia=null;
            $conexion=null;
            die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
        }

        if($sentencia->rowCount()<=0)
        {
            echo "<p>No hay usuarios con esas credenciales en la BD</p>";
        }
        else
        {
            $respuesta=$sentencia->fetchAll(PDO::FETCH_ASSOC);//otras Ctes: PDO::FETCH_NUM, PDO::FETCH_OBJECT
            foreach($respuesta as $tupla)
                echo "<p>El nombre del usuario logueado es: <strong>".$tupla["nombre"]."</strong></p>";

        }
        $sentencia=null;
        $conexion=null;
        */
        /*
        $nombre="Pepe Castro";
        $usuario="pepe88";
        $clave=md5("123456");
        $email="sdjfhds@jsj.es";
        try{
            $consulta="insert into usuarios(nombre,usuario,clave,email) values('".$nombre."','".$usuario."','".$clave."','".$email."')";
            mysqli_query($conexion, $consulta);
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
        }
        echo "<p>Usuario insertado con éxito con la id_usuario:<strong>".mysqli_insert_id($conexion)."</strong></p>";
        mysqli_close($conexion);
        */
        $nombre="Pepe Castro2";
        $usuario="pepe89";
        $clave=md5("123456");
        $email="sdjfhds78@jsj.es";
        try{
            $consulta="insert into usuarios(nombre,usuario,clave,email) values(?,?,?,?)";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$nombre,$usuario,$clave,$email]);
        }
        catch(PDOException $e)
        {
            $sentencia=null;
            $conexion=null;
            die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
        }
        echo "<p>Usuario insertado con éxito con la id_usuario:<strong>".$conexion->lastInsertId()."</strong></p>";
        $sentencia=null;
        $conexion=null;
    ?>
</body>
</html>