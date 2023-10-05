<!DOCTYPE html>
<html lang="es">

<head>
    <title>Práctica 1 - Formulario</title>
    <style>
        .error {
            color: red
        }
    </style>
</head>

<body>
    <h2>Rellena tu CV</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre</label><br />
        <input type="text" id="nombre" name="nombre" value="<?php if (isset($_POST["nombre"])) {
                                                                echo $_POST["nombre"];
                                                            } ?>" />
        <?php
        if (isset($_POST["btnEnviar"]) && $error_nombre) { // El orden importa para el error
            echo "<span class='error'> Campo vacio </span>";
        }
        ?>
        <br />

        <label for="apellidos">Apellidos</label><br />
        <input type="text" id="apellidos" name="apellidos" size="50" value="<?php if (isset($_POST["apellidos"])) {
                                                                                echo $_POST["apellidos"];
                                                                            } ?>" />
        <?php
        if (isset($_POST["btnEnviar"]) && $error_apellidos) { // El orden importa para el error
            echo "<span class='error'> Campo vacio </span>";
        }
        ?>
        <br />

        <label for="contra">Contraseña</label><br />
        <input type="password" id="contra" name="contra" />
        <?php
        if (isset($_POST["btnEnviar"]) && $error_contra) { // El orden importa para el error
            echo "<span class='error'> Campo vacio </span>";
        }
        ?>
        <br />

        <label for="dni">DNI</label><br />
        <input type="text" placeholder="DNI: 11223344Z" id="dni" name="dni" size="10" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"]; ?>" />
        <?php
        if (isset($_POST["dni"]) && $error_dni) {
            if ($error_dni_vacio) {
                echo "<span class='error'> Campo vacio </span>";
            } else if ($error_formato_dni) {
                echo "<span class='error'> Error en el formato del dni </span>";
            } else {
                echo "<span class='error'> Error en la letra de dni </span>";
            }
        }
        ?>
        <br />

        <label>Sexo</label>
        <?php
        if (isset($_POST["btnEnviar"]) && $error_sexo) { // El orden importa para el error
            echo "<span class='error'> Campo vacio </span>";
        }
        ?>
        <br />
        <input type="radio" id="hombre" name="sexo" value="hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") {
                                                                        echo "checked";
                                                                    } ?> /> <label for="hombre">Hombre</label><br />
        <input type="radio" id="mujer" name="sexo" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") {
                                                                        echo "checked";
                                                                    } ?> /> <label for="mujer">Mujer</label>

        <p><label for="archivo">Incluir mi foto:</label> <input type="file" id="archivo" name="archivo" accept="image/*" />
            <?php
            if (isset($_POST["btnEnviar"]) && $_FILES["archivo"]["name"] != "" && $error_imagen) {
                if ($error_tipo) {
                    echo "<span class='error'>El archivo subido no es de un tipo imagen</span>";
                } else {
                    echo "<span class='error'>El archivo subido supera los 500KB</span>";
                }
            }
            ?>
        </p>

        <p><label for="nacido">Nacido en: </label>
            <select id="nacido" name="nacido">
                <option <?php if (isset($_POST["btnEnviar"]) && $_POST["nacido"] == "Málaga") {
                            echo "selected";
                        } ?>>Málaga</option>
                <option <?php if (isset($_POST["btnEnviar"]) && $_POST["nacido"] == "Sevilla") {
                            echo "selected";
                        } ?>>Sevilla</option>
                <option <?php if (!isset($_POST["btnEnviar"]) || (isset($_POST["btnEnviar"]) && $_POST["nacido"] == "Granada")) {
                            echo "selected";
                        } ?>>Granada</option>
            </select>
        </p>

        <p><label for="comentario">Comentarios:</label>
            <textarea id="comentario" name="comentarios"><?php
                                                            if (isset($_POST["comentarios"])) {
                                                                echo $_POST["comentarios"];
                                                            }
                                                            ?></textarea>
            <?php
            if (isset($_POST["btnEnviar"]) && $error_comentarios) { // El orden importa para el error
                echo "<span class='error'> Campo vacio </span>";
            }
            ?>
        </p>

        <p><input type="checkbox" name="subscripcion" id="sub" checked /> <label for="sub">Subscribirse al boletín de Novedades</label></p>

        <input type="submit" name="btnEnviar" value="Guardar Cambios" /> <input type="submit" name="btnBorrar" value="Borrar los datos introducidos" />
    </form>
</body>

</html>