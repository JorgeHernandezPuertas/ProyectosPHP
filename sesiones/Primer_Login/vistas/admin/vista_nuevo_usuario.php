<div class="centrado">
        <h2>Usuario Nuevo</h2>
        <form action="index.php" method="post">
            <p>
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php  if(isset($_POST["nombre"])) echo $_POST["nombre"];?>">
                <?php
                if(isset($_POST["btnContInsertar"]) && $error_nombre)
                {
                    if($_POST["nombre"]=="")
                        echo "<span class='error'> Campo vacío</span>";
                    else
                        echo "<span class='error'> Has tecleado más de 30 caracteres</span>";
                }
                ?>
            </p>
            <p>
                <label for="usuario">Usuario: </label>
                <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php  if(isset($_POST["usuario"])) echo $_POST["usuario"];?>" >
                <?php
                if(isset($_POST["btnContInsertar"]) && $error_usuario)
                {
                    if($_POST["usuario"]=="")
                        echo "<span class='error'> Campo vacío</span>";
                    elseif(strlen($_POST["usuario"])>20)
                        echo "<span class='error'> Has tecleado más de 20 caracteres</span>";
                    else
                        echo "<span class='error'> Usuario repetido</span>";
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña: </label>
                <input type="password" name="clave" maxlength="15" id="clave" >
                <?php
                if(isset($_POST["btnContInsertar"]) && $error_clave)
                {
                    if($_POST["clave"]=="")
                        echo "<span class='error'> Campo vacío</span>";
                    else
                        echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
                }
                ?>
            </p>
            <p>
                <label for="email">Email: </label>
                <input type="text" name="email" id="email" maxlength="50" value="<?php  if(isset($_POST["email"])) echo $_POST["email"];?>">
                <?php
                if(isset($_POST["btnContInsertar"]) && $error_email)
                {
                    if($_POST["email"]=="")
                        echo "<span class='error'> Campo vacío</span>";
                    elseif(strlen($_POST["email"])>50)
                        echo "<span class='error'> Has tecleado más de 50 caracteres</span>";
                    elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
                        echo "<span class='error'> Email sintáxticamente incorrecto</span>";
                    else
                        echo "<span class='error'> Email repetido</span>";
                }
                ?>
            </p>
            <p>
                <label>Tipo: </label>
                <input type="radio"  <?php if(isset($_POST["btnContInsertar"]) && $_POST["tipo"]=="admin") echo "checked"; ?> name="tipo" value="admin" id="admin">
                <label for="admin"> Administrador</label> 
                <input type="radio" name="tipo" value="normal" id="normal" <?php if(!isset($_POST["btnContInsertar"]) ||  $_POST["tipo"]=="normal") echo "checked"; ?>>
                <label for="normal"> Normal</label> 
            </p>
            <p>
                <button type="submit" name="btnContInsertar">Continuar</button> 
                <button type="submit">Volver</button> 
            </p>
        </form>
        </div>