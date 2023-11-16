<h2>Agregar Nuevo Usuario</h2>
<form action="index.php" method="post" enctype="multipart/form-data">
    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre..." value="<?php if (isset($_POST["btnGuardarInsertar"])) print $_POST["nombre"] ?>" >
    <?php
    if (isset($_POST["btnGuardarInsertar"]) && $error_nombre){
        if ($_POST["nombre"] == ""){
            print "<span class='error'>* Campo obligatorio *</span>";
        } else {
            print "<span class='error'>* El nombre tiene más de 50 caracteres *</span>";
        }
    }
    ?>
    <br>
    <label for="usuario">Usuario:</label><br>
    <input type="text" name="usuario" id="usuario" placeholder="usuario..." value="<?php if (isset($_POST["btnGuardarInsertar"])) print $_POST["usuario"] ?>" >
    <?php
    if (isset($_POST["btnGuardarInsertar"]) && $error_usuario){
        if ($_POST["usuario"] == ""){
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
    if (isset($_POST["btnGuardarInsertar"]) && $error_psw){
        if ($_POST["psw"] == ""){
            print "<span class='error'>* Campo obligatorio *</span>";
        } else {
            print "<span class='error'>* La contraseña tiene más de 15 caracteres *</span>";
        }
    }
    ?>
    <br>
    <label for="dni">DNI:</label><br>
    <input type="text" name="dni" id="dni" placeholder="DNI:11223344Z" value="<?php if (isset($_POST["btnGuardarInsertar"])) print $_POST["dni"] ?>" >
    <?php
    if (isset($_POST["btnGuardarInsertar"]) && $error_dni){
        if ($_POST["dni"] == ""){
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
    <input type="radio" name="sexo" value="mujer" id="mujer" <?php if (isset($_POST["btnGuardarInsertar"]) && $_POST["sexo"] == "mujer") print "checked" ?> > <label for="mujer">Mujer</label><br>
    <label for="foto">Incluir mi foto (Max. 500KB)</label> <input type="file" name="foto" id="foto" accept="image/*">
    <?php
    if (isset($_POST["btnGuardarInsertar"]) && $error_foto){
        if (!getimagesize($_FILES["foto"]["tmp_name"])){
            print "<span class='error'>* El archivo subido no es una imagen *</span>";
        } else if ($_FILES["foto"]["size"] > 500 * 1024) {
            print "<span class='error'>* La imagen subida sobrepasa el tamaño máximo *</span>";
        } else {
            print "<span class='error'>* La imagen subida no tiene extensión *</span>";
        }
    }
    ?>
    <br>
    <button type="submit" name="btnGuardarInsertar">Guardar Cambios</button> <button type="submit">Atrás</button>
</form>