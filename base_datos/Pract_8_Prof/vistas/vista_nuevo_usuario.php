<h2>Agregar Nuevo Usuario</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="nombre">Nombre</label><br/>
            <input type="text" name="nombre" id="nombre" maxlength="50" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/>
            <?php
            if(isset($_POST["btnContNuevo"])&& $error_nombre)
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
            <input type="text" name="usuario" id="usuario" maxlength="50" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"];?>"/>
            <?php
            if(isset($_POST["btnContNuevo"])&& $error_usuario)
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
            if(isset($_POST["btnContNuevo"])&& $error_clave)
            {
                if($_POST["clave"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                else
                    echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
            }
            ?>
        </p>
        <p>
            <label for="dni">DNI:</label><br/>
            <input type="text" placeholder="DNI: 11223344Z" maxlength="9" name="dni" id="dni" value="<?php if(isset($_POST["dni"])) echo $_POST["dni"];?>"/>
            <?php
            if(isset($_POST["btnContNuevo"])&& $error_dni)
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

        <p>Sexo
        <?php
            if(isset($_POST["btnContNuevo"])&& $error_sexo)
                echo "<span class='error'> Debes seleccionar un Sexo </span>";
            ?>
            <br/>
            <input type="radio" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="hombre") echo "checked";?> name="sexo" id="hombre" value="hombre"/><label for="hombre">Hombre</label><br/>
            <input type="radio" <?php if(isset($_POST["sexo"]) && $_POST["sexo"]=="mujer") echo "checked";?> name="sexo" id="mujer" value="mujer"/><label for="mujer">Mujer</label>
        </p>
        <p>
            <label for="foto">Incluir mi foto (Max. 500KB)</label>
            <input type="file" name="foto" id="foto" accept="image/*"/>
            <?php
            if(isset($_POST["btnContNuevo"]) && $error_foto)
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
            <button type="submit" name="btnContNuevo">Guardar Cambios</button>
            <button type="submit" >Atras</button>
        </p>
        
    </form>