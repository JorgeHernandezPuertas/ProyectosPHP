<?php
$id_usuario = isset($_POST["btnEditar"]) ? $_POST["btnEditar"]:$_POST["id_usuario"];
?>

<h2>Modificando el usuario: <?php print $id_usuario ?></h2>
<?php
if (!isset($bd)) {
    $bd = conectarBD();
    if (is_string($bd)) {
        die("<p>Ha ocurrido un error conectandose a la BD: $bd</p>");
    }
}

try {
    $consulta = "select * from usuarios where id_usuario='" . $id_usuario . "'";
    $resultado = mysqli_query($bd, $consulta);
} catch (mysqli_sql_exception $e) {
    mysqli_close($bd);
    die("<p>Ha ocurrido un error conectandose a la BD: $e</p>");
}

$fila = mysqli_fetch_assoc($resultado);

?>
<form action="index.php" method="post" enctype="multipart/form-data" class="paralelo">
    <div>
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre..." value="<?php print $fila["nombre"] ?>">
        <?php
        if (isset($_POST["btnGuardarMod"]) && $error_nombre) {
            if ($_POST["nombre"] == "") {
                print "<span class='error'>* Campo obligatorio *</span>";
            } else {
                print "<span class='error'>* El nombre tiene más de 50 caracteres *</span>";
            }
        }
        ?>
        <br>
        <label for="usuario">Usuario:</label><br>
        <input type="text" name="usuario" id="usuario" placeholder="usuario..." value="<?php print $fila["usuario"] ?>">
        <?php
        if (isset($_POST["btnGuardarMod"]) && $error_usuario) {
            if ($_POST["usuario"] == "") {
                print "<span class='error'>* Campo obligatorio *</span>";
            } else if (strlen($_POST["usuario"]) > 30) {
                print "<span class='error'>* El usuario tiene más de 30 caracteres *</span>";
            } else {
                print "<span class='error'>* El usuario ya está en uso *</span>";
            }
        }
        ?><br>
        <label for="psw">Contraseña:</label><br>
        <input type="password" name="psw" id="psw" placeholder="Contraseña...">
        <?php
        if (isset($_POST["btnGuardarMod"]) && $error_psw) {
            if ($_POST["psw"] == "") {
                print "<span class='error'>* Campo obligatorio *</span>";
            } else {
                print "<span class='error'>* La contraseña tiene más de 15 caracteres *</span>";
            }
        }
        ?>
        <br>
        <label for="dni">DNI:</label><br>
        <input type="text" name="dni" id="dni" placeholder="DNI:11223344Z" value="<?php print $fila["dni"] ?>">
        <?php
        if (isset($_POST["btnGuardarMod"]) && $error_dni) {
            if ($_POST["dni"] == "") {
                print "<span class='error'>* Campo obligatorio *</span>";
            } else if (!preg_match("/^[0-9]{8}[A-Z]$/", $dni_mayus)) {
                print "<span class='error'>* El DNI introducido no cumple el formato *</span>";
            } else if (!(LetraNIF(substr($dni_mayus, 0, 8)) == substr($dni_mayus, -1))) {
                print "<span class='error'>* La letra del DNI no es la que le corresponde *</span>";
            } else {
                print "<span class='error'>* El DNI ya está en uso *</span>";
            }
        }
        ?><br>
        <label for="">Sexo</label><br>
        <input type="radio" name="sexo" value="hombre" id="hombre" checked> <label for="hombre">Hombre</label><br>
        <input type="radio" name="sexo" value="mujer" id="mujer" <?php if ($fila["sexo"] == "mujer") print "checked" ?>> <label for="mujer">Mujer</label><br>
        <label for="foto">Incluir mi foto (Max. 500KB)</label> <input type="file" name="foto" id="foto" accept="image/*">
        <?php
        if (isset($_POST["btnGuardarMod"]) && $error_foto) {
            if (!getimagesize($_FILES["foto"]["tmp_name"])) {
                print "<span class='error'>* El archivo subido no es una imagen *</span>";
            } else if ($_FILES["foto"]["size"] > 500 * 1024) {
                print "<span class='error'>* La imagen subida sobrepasa el tamaño máximo *</span>";
            } else {
                print "<span class='error'>* La imagen subida no tiene extensión *</span>";
            }
        }
        $foto_ant = isset($_POST["btnEditar"]) ? $_POST["foto"] : $_POST["fotoAnt"];
        print "<br>";
        print "<input type='hidden' name='id_usuario' value='$id_usuario' >";
        ?>
        <br>
        <input type="hidden" name="fotoAnt" value="<?php print $foto_ant ?>">
        <button type="submit" name="btnGuardarMod" value="<?php print $id_usuario ?>">Guardar Cambios</button> <button type="submit">Atrás</button>
    </div>
    <div>
        <img src='Img/<?php print $foto_ant ?>' alt='Foto de perfil actual' class='foto-perfil'><br>
        <?php
        if (isset($_POST["btnBorrarFoto"])) {
            print "<p>¿Seguro que quieres borrar la foto?</p><br>";
            print "<button name='btnContBorrarFoto' >Sí</button> <button name='btnNoBorrarFoto'>No</button>";
        } else if ($foto_ant != "no_imagen.jpg") {
        ?>
            <button type="submit" name="btnBorrarFoto" value="<?php print $id_usuario ?>">Borrar foto</button>
        <?php
        }
        ?>

    </div>
</form>