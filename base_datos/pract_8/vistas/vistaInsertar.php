<h2>Agregar Nuevo Usuario</h2>
<form action="index.php" method="post" enctype="multipart/form-data">
    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre...">
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
    <input type="text" name="usuario" id="usuario" placeholder="usuario...">
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
    <input type="text" name="dni" id="dni" placeholder="DNI:11223344Z">
    <?php
    if (isset($_POST["btnGuardarInsertar"]) && $error_dni){
        if ($_POST["dni"] == ""){
            print "<span class='error'>* Campo obligatorio *</span>";
        } else if (!preg_match("/^[0-9]{8}[A-Z]$/", $_POST["dni"])) {
            print "<span class='error'>* El DNI introducido no cumple el formato *</span>";
        } else {
            print "<span class='error'>* El DNI ya está en uso *</span>";
        }
    }
    ?><br>
    <label for="">Sexo</label><br>
    <input type="radio" name="sexo" value="hombre" id="hombre" checked> <label for="hombre">Hombre</label><br>
    <input type="radio" name="sexo" value="mujer" id="mujer"> <label for="mujer">Mujer</label><br>
    <label for="foto">Incluir mi foto (Max. 500KB)</label> <input type="file" name="foto" id="foto" accept="image/*"><br>
    <button type="submit" name="btnGuardarInsertar">Guardar Cambios</button> <button type="submit">Atrás</button>
</form>