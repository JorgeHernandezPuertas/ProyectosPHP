<?php
if(isset($_POST["btnContInsertar"]) )
{
   
    $error_nombre=$_POST["nombre"]==""|| strlen($_POST["nombre"])>30;
    $error_usuario=$_POST["usuario"]==""|| strlen($_POST["usuario"])>20;
    if(!$error_usuario)
    {
        

        $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"]);
        
        if(is_string($error_usuario))
        {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Primer Login","<h1>Primer Login</h1><p>No se ha podido realizar la consulta: ".$error_usuario."</p>"));
        }
            
    }

    $error_clave=$_POST["clave"]=="" || strlen($_POST["clave"])>15;
    $error_email=$_POST["email"]=="" || strlen($_POST["email"])>50 || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
    if(!$error_email)
    {
        
        $error_email=repetido($conexion,"usuarios","email",$_POST["email"]);
        
        if(is_string($error_email))
        {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No ha podido realizarse la consulta: ".$error_email."</p>"));
        }
            

        
    }
    $error_form=$error_nombre||$error_usuario||$error_clave||$error_email;

    if(!$error_form)
    {
        try{
            $consulta="insert into usuarios (nombre,usuario,clave,email,tipo) values ('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["clave"])."','".$_POST["email"]."','".$_POST["tipo"]."')";
            mysqli_query($conexion,$consulta);
        }
        catch(Exception $e)
        {
            session_destroy();
            mysqli_close($conexion);
            die(error_page("Práctica 1º CRUD","<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: ".$e->getMessage()."</p>"));
        }
        
        $_SESSION["mensaje"]="El usuario ha sido creado con éxito";
        header("Location:index.php");
        exit;
        
    }

        
    
}

if(isset($_POST["btnContEditar"]))
{
    //Errores cuándo edito
    $error_nombre=$_POST["nombre"]=="" || strlen($_POST["nombre"])>30;
    $error_usuario=$_POST["usuario"]==""|| strlen($_POST["usuario"])>20;
    if(!$error_usuario)
    {
        
        $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"],"id_usuario",$_POST["btnContEditar"]);
            
        if(is_string($error_usuario))
        {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Primer Login","<h1>Primer Login</h1><p>No se ha podido realizar la consulta: ".$error_usuario."</p>"));
        }
            
    }
    $error_clave=strlen($_POST["clave"])>15;
    $error_email=$_POST["email"]=="" || strlen($_POST["email"])>50 || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
    if(!$error_email)
    {
       
        $error_email=repetido($conexion,"usuarios","email",$_POST["email"],"id_usuario",$_POST["btnContEditar"]);
        
        if(is_string($error_email))
        {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Primer Login","<h1>Primer Login</h1><p>No se ha podido realizar la consulta: ".$error_email."</p>"));
        }
            
    }

    $error_form=$error_nombre||$error_usuario||$error_clave||$error_email;

    if(!$error_form)
    {
        try{

            if($_POST["clave"]=="")
                $consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', email='".$_POST["email"]."', tipo='".$_POST["tipo"]."' where id_usuario='".$_POST["btnContEditar"]."'";
            else
                $consulta="update usuarios set nombre='".$_POST["nombre"]."', usuario='".$_POST["usuario"]."', clave='".md5($_POST["clave"])."', email='".$_POST["email"]."', tipo='".$_POST["tipo"]."' where id_usuario='".$_POST["btnContEditar"]."'";
            
            mysqli_query($conexion,$consulta);
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Primer Login","<h1>Primer Login</h1><p>No se ha podido realizar la consulta:".$e->getMessage()."</p>"));
        }
        
        mysqli_close($conexion);
        $_SESSION["mensaje"]="El usuario ha sido actualizado con éxito";
        header("Location:index.php");
        exit;
        
    }

}


if(isset($_POST["btnContBorrar"]))
{
   

    try{
        $consulta="delete from usuarios where id_usuario='".$_POST["btnContBorrar"]."'";
        mysqli_query($conexion, $consulta);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        session_destroy();
        die(error_page("Primer Login","<h1>Primer Login</h1><p>No ha podido realizarse la consulta: ".$e->getMessage()."</p>"));
    }

    mysqli_close($conexion);
    $_SESSION["mensaje"]="El usuario ha sido borrado con éxito";
    header("Location:index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login</title>
    <style>
        .enlinea{display:inline}
        td,th{border:1px solid black}
        table{border-collapse:collapse}
        th{background-color:#CCC}
        table img{width:50px;}
        .enlace{border:none;background:none;cursor:pointer;color:blue;text-decoration:underline}
        .error{color:red}
        .mensaje{color:blue;font-size:1.5em} 
        .txt_centrado{text-align:center}
        .no_bordes{border:none}
        .centrado{width:80%;margin:0 auto}
        .grande{font-size:1.5em}
    </style>
</head>
<body>
    <h1>Primer Login - Vista Admin</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_logueado["nombre"];?></strong> - 
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <?php
    
    require "vistas/admin/vista_tabla_principal.php";

    if(isset($_POST["btnDetalle"]))
    {
        require "vistas/admin/vista_detalle.php";
    }
    elseif(isset($_POST["btnBorrar"]))
    {
        require "vistas/admin/vista_conf_borrar.php";
    }
    elseif(isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"]) )
    {
        require "vistas/admin/vista_editar.php";
    }
    elseif(isset($_POST["btnNuevo"])||isset($_POST["btnContInsertar"]))
    {
        require "vistas/admin/vista_nuevo_usuario.php";
    }
    ?>

    
</body>
</html>
