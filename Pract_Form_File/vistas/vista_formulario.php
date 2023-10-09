<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rellena tu CV</title>
    <style>
        .error {color:red}
    </style>
</head>

<body>
    <h1>Rellena tu CV</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="nombre">Nombre:</label><br/>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre..." 
            value="<?php if (isset($_POST["btnEnviar"])) print $_POST["nombre"];?>" />
            <?php
            if (isset($_POST["btnEnviar"]) && $error_nombre){
                print "<span class='error'> *Campo obligatorio* </span>";
            }
            ?>
        </p>
        <p>
            <label for="usuario">Usuario:</label><br/>
            <input type="text" id="usuario" name="usuario" placeholder="Usuario..." 
            value="<?php if (isset($_POST["btnEnviar"])) print $_POST["usuario"];?>" />
            <?php
            if (isset($_POST["btnEnviar"]) && $error_usuario){
                print "<span class='error'> *Campo obligatorio* </span>";
            }
            ?>
        </p>
        <p>
            <label for="password">Contraseña</label><br/>
            <input type="password" name="password" id="password" placeholder="Contraseña..." />
            <?php
            if (isset($_POST["btnEnviar"]) && $error_password){
                print "<span class='error'> *Campo obligatorio* </span>";
            }
            ?>
        </p>
        <p>
            <label for="dni">DNI:</label><br/>
            <input type="text" name="dni" id="dni" placeholder="DNI: 11223344Z" 
            value="<?php if (isset($_POST["btnEnviar"])) print $_POST["dni"];?>" />
            <?php
            if (isset($_POST["btnEnviar"]) && $error_dni_vacio){
                print "<span class='error'> *Campo obligatorio* </span>";
            } else if (isset($_POST["btnEnviar"]) && $error_dni_formato){
                print "<span class='error'> *El DNI no cumple el formato* </span>";
            } else if (isset($_POST["btnEnviar"]) && $error_dni_letra) {
                print "<span class='error'> *El DNI no es válido* </span>";
            }
            ?>
        </p>
        <p>
            <label>Sexo:</label>
            <?php
            if (isset($_POST["btnEnviar"]) && $error_sexo){
                print "<span class='error'> *Campo obligatorio* </span>";
            }
            ?>
            <br />
            <input type="radio" name="sexo" value="hombre" id="hombre" />
            <label for="hombre">Hombre</label><br/>
            <input type="radio" name="sexo" value="mujer" id="mujer" />
            <label for="mujer">Mujer</label>
        </p>
        <p>
            <label for="imagen">Incluir mi foto (Archivo de tipo imagen Máx. 500KB): </label>
            <input type="file" name="imagen" id="imagen" accept="image/*" />
            <?php
            if ($_FILES["imagen"]["name"] != ""){
                if ($error_tipo){
                    print "<span class='error'> *No has introducido una imagen* </span>";
                } else if ($error_tam){
                    print "<span class='error'> *El  tamaño de la foto excede los 500KB* </span>";
                }
            }
            ?>
        </p>
        <p>
            <input type="checkbox" name="sub" id="sub" <?php if (isset($_POST["sub"])) print "checked"; ?> />
            <label for="sub">Subcribirme al boletín de Novedades.</label>
        </p>
        <input type="submit" value="Guardar cambios" name="btnEnviar" /> 
        <input type="submit" value="Borrar los datos introducidos" name="btnReset" />
    </form>
</body>

</html>