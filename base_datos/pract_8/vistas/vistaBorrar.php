<?php
if (isset($_POST["btnBorrar"])) {
?>
    <p>Se dispone usted a borrar al usuario con id: <?php print $_POST["btnBorrar"] ?></p>
    <form action="index.php" method="post">
        <input type="hidden" name="foto" value="<?php print $_POST["foto"] ?>">
        <button type="submit" name="btnBorrarCont" value="<?php print $_POST["btnBorrar"] ?>">Continuar</button>
        <button type="submit">Atrás</button>
    </form>
<?php
} else {
    // Si no estoy conectado me conecto
    if (!isset($bd)) {
        $bd = conectarBD();
        if (is_string($bd)){
            die("<p>Ha ocurrido un error intentando conectarse a la BD: $bd</p>");
        }
    }
    // Borro al usuario solicitado
    try {
        $consulta = "delete from usuarios where id_usuario=". $_POST["btnBorrarCont"];
        $resultado = mysqli_query($bd, $consulta);
    } catch (mysqli_sql_exception $e){
        mysqli_close($bd);
        die("<p>Ha ocurrido un error borrar al usuario de la BD: $e</p>");
    }

    // Borro la imagen del servidor
    if ($_POST["foto"] != "no_imagen.jpg"){
        if (!unlink("Img/".$_POST["foto"])){
            mysqli_close($bd);
            die("Ha ocurrido un error borrando la foto de perfil del usuario del servidor");
        }
    }
    
    print "<p>El usuario seleccionado ha sido borrado con éxito</p>";

}
?>