<?php
if(isset($_POST["btnEditar"]))
    $id_usuario=$_POST["btnEditar"];
else
    $id_usuario=$_POST["id_usuario"];

// Abro conexión si aún no ha sido abierta
if(!isset($conexion))
{
    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        die("<p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p></body></html>");
    }  
}

try{
    $consulta="select * from usuarios where id_usuario='".$id_usuario."'";
    $resultado=mysqli_query($conexion, $consulta);
}
catch(Exception $e)
{
    mysqli_close($conexion);
    die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

if(mysqli_num_rows($resultado)>0)
{
    //recojo datos
    if(isset($_POST["btnEditar"]))
    {
        //recojo de la BD
        $datos_usuario=mysqli_fetch_assoc($resultado);
        mysqli_free_result($resultado);
        $nombre=$datos_usuario["nombre"];
        $usuario=$datos_usuario["usuario"];
        $dni=$datos_usuario["dni"];
        $sexo=$datos_usuario["sexo"];
        $foto=$datos_usuario["foto"];
    }
    else
    {
        //recojo del $_POST
        $nombre=$_POST["nombre"];
        $usuario=$_POST["usuario"];
        $dni=$_POST["dni"];
        $sexo=$_POST["sexo"];
        $foto=$_POST["foto_bd"];//Lo meto en un hidden porque en el $_POST no está
    }

}
else
{
    $error_existencia="<p>El usuario seleccionado ya no se encuentra en la BD</p>";
}

if(isset($error_existencia))
{
    echo "<h2>Editando el usuario con id ".$id_usuario."</h2>";
    echo $error_existencia;
    echo "<form action='index.php' method='post'>";
    echo "<p><button type='submit'>Volver</button></p>";
    echo "</form>";
}
else
{
    //Pongo el formulario
?>
    <h2>Editando el usuario con id <?php echo $id_usuario;?></h2>
    
    
    <form action="index.php" method="post" enctype="multipart/form-data" class="paralelo">
    <div>
        <p>
            <label for="nombre">Nombre</label><br/>
            <input type="text" name="nombre" id="nombre" maxlength="50" value="<?php echo $nombre;?>"/>
            <?php
            if(isset($_POST["btnContEditar"])&& $error_nombre)
            {
                if($_POST["nombre"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                else
                    echo "<span class='error'> Has tecleado más de 50 caracteres</span>";
            }
            ?>
        </p>
        <p>
            <label for="usuario">Usuario</label><br/>
            <input type="text" name="usuario" id="usuario" maxlength="50" value="<?php echo $usuario;?>"/>
            <?php
            if(isset($_POST["btnContEditar"])&& $error_usuario)
            {
                if($_POST["usuario"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(strlen($_POST["usuario"])>50)
                    echo "<span class='error'> Has tecleado más de 50 caracteres</span>";
                else
                    echo "<span class='error'> Usuario repetido</span>";
            }
                
            ?>
        </p>
        <p>
            <label for="clave">Contraseña</label><br/>
            <input type="password" name="clave" id="clave" maxlength="15"/>
            <?php
            if(isset($_POST["btnContEditar"])&& $error_clave)
            {
                echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
            }
            ?>
        </p>
        <p>
            <label for="dni">DNI:</label><br/>
            <input type="text" placeholder="DNI: 11223344Z" maxlength="9" name="dni" id="dni" value="<?php echo $dni;?>"/>
            <?php
            if(isset($_POST["btnContEditar"])&& $error_dni)
            {
                if($_POST["dni"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(!dni_bien_escrito($dni_may))
                    echo "<span class='error'> DNI no está bien escrito </span>";
                elseif(!dni_valido($dni_may))
                    echo "<span class='error'> DNI no válido </span>";
                else
                    echo "<span class='error'> DNI repetido </span>";
            }
                
            ?>
        </p>

        <p>Sexo<br>
        
            <input type="radio" <?php if($sexo=="hombre") echo "checked";?> name="sexo" id="hombre" value="hombre"/><label for="hombre">Hombre</label><br/>
            <input type="radio" <?php if($sexo=="mujer") echo "checked";?> name="sexo" id="mujer" value="mujer"/><label for="mujer">Mujer</label>
        </p>
        <p>
            <label for="foto">Incluir mi foto (Max. 500KB)</label>
            <input type="file" name="foto" id="foto" accept="image/*"/>
            <?php
            if(isset($_POST["btnContEditar"]) && $error_foto)
            {
                if($_FILES["foto"]["error"])
                    echo "<span class='error'> No se ha podido subir el archivo al servidor</span>";
                elseif(!getimagesize( $_FILES["foto"]["tmp_name"]))
                    echo "<span class='error'> No has seleccionado un archivo de tipo imagen</span>";
                elseif(!tiene_extension($_FILES["foto"]["name"]))
                    echo "<span class='error'> Has seleccionado un archivo imagen sin extensión</span>";
                else
                    echo "<span class='error'> El archivo seleccionado supera los 500KB</span>";
            }
            ?>
        </p>
        
        <p>
            <input type="hidden" name="foto_bd" value="<?php echo $foto;?>">
            <input type="hidden" name="id_usuario" value="<?php echo $id_usuario;?>">
            <button type="submit" name="btnContEditar">Continuar</button>
            <button type="submit" >Atrás</button>
        </p>
        </div>
        <div>
            <p class="centrado">
                <img class="foto_detalle" src="Img/<?php echo $foto;?>" title="Foto de Perfil" alt="Foto de Perfil"><br>
                <?php
                if(isset($_POST["btnBorrarFoto"]))
                    echo "¿Estás seguro que quieres borra la foto?<br><br><button name='btnContBorrarFoto'>Si</button><button name='btnNoBorrarFoto'>No</button>";
                elseif($foto!="no_imagen.jpg")
                    echo '<button name="btnBorrarFoto">Borrar Foto</button>';
                ?>
            </p>
        </div>
    </form>
    
<?php  
}