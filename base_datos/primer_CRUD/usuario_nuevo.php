<?php
if (isset($_POST["btnNuevoUsuario"]) || isset($_POST["btnContinuar"])) {
    if (isset($_POST["btnContinuar"])) {

        $error_form = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30 
        || $_POST["usuario"] == "" ||  strlen($_POST["usuario"]) > 20
        || $_POST["psw"] == "" ||  strlen($_POST["psw"]) > 50
        || $_POST["email"] == "" ||  strlen($_POST["email"]) > 50 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    }

?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nuevo Usuario</title>
    </head>

    <body>
        <h1>Nuevo Usuario</h1>

        <form action="usuario_nuevo.php" method="post">
            <p>
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if (isset($_POST["nombre"])) print $_POST["nombre"] ?>">
                <?php
                    if (isset($_POST["btnContinuar"])){
                        if ($_POST["nombre"] == ""){
                            print "<span class='error'> * Campo obligatorio * </span>";
                        }
                    }
                ?>
            </p>
            <p>
                <label for="usuario">Usuario: </label>
                <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if (isset($_POST["usuario"])) print $_POST["usuario"] ?>">
            </p>
            <p>
                <label for="psw">Contraseña: </label>
                <input type="password" name="psw" id="psw" maxlength="15" >
            </p>
            <p>
                <label for="email">Email: </label>
                <input type="text" name="email" id="email" maxlength="50" value="<?php if (isset($_POST["email"])) print $_POST["email"] ?>">
            </p>
            <p>
                <button type="submit" name="btnContinuar" id="boton-continuar">Continuar</button>
                <button type="submit" name="btnVolver" id="boton-volver">Volver</button>
            </p>
        </form>
    </body>

    </html>
<?php
} else {
    header("Location: index.php");
}
?>