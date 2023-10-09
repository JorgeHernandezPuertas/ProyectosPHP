<?php
    function en_array($valor, $arr){
        $esta = false;
        foreach($arr as $aux){
            if ($aux == $valor){
                $esta = true;
                break;
            }
        }
        return $esta;
    }
?>


<!DOCTYPE html>
    <html lang="es">
    <head>
        <title>Mi primera página PHP</title>
    </head>
    <body>
        <h2>Esta es mi super página</h2>
        <form  action="index.php" method="post" enctype="multipart/form-data">
            <p>
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre" value="<?php if (isset($_POST["nombre"])){echo $_POST["nombre"];} ?>" />
            <?php
                if (isset($_POST["btnEnviar"]) && $error_nombre){ // El orden importa para el error
                    echo "<span> *Campo obligatorio* </span>";
                }
            ?>
            </p>

            <p><label for="nacido">Nacido en: </label>
                <select id="nacido" name="nacido">
                    <option <?php if (isset($_POST["btnEnviar"]) && $_POST["nacido"] == "Málaga"){echo "selected";}?>>Málaga</option>
                    <option <?php if (isset($_POST["btnEnviar"]) && $_POST["nacido"] == "Sevilla"){echo "selected";} ?>>Sevilla</option>
                    <option <?php if (isset($_POST["btnEnviar"]) && $_POST["nacido"] == "Granada"){echo "selected";} ?>>Granada</option>
                </select>
            </p>

            <label>Sexo: </label>
            <label for="hombre">Hombre</label><input type="radio" id="hombre" name="sexo" value="hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre"){echo "checked";} ?> /> 
            <label for="mujer">Mujer</label><input type="radio" id="mujer" name="sexo" value="mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer"){echo "checked";} ?> /> 
            <?php
                if (isset($_POST["btnEnviar"]) && $error_sexo){ // El orden importa para el error
                    echo "<span> *Campo obligatorio* </span>";
                }
            ?>

        <p>
            <label>Aficiones: </label>
            <label for="deportes">Deportes</label>
            <input type="checkbox" name="aficiones[]" id="deportes" value="Deportes" <?php if (isset($_POST["aficiones"]) && en_array("Deportes", $_POST["aficiones"])){ echo "checked";} ?> /> 
            <label for="lectura">Lectura</label>
            <input type="checkbox" name="aficiones[]" id="lectura" value="Lectura" <?php if (isset($_POST["aficiones"]) && en_array("Lectura", $_POST["aficiones"])){ echo "checked";} ?>/> 
            <label for="otros">Otros</label>
            <input type="checkbox" name="aficiones[]" id="otros" value="Otros" <?php if (isset($_POST["aficiones"]) && en_array("Otros", $_POST["aficiones"])){ echo "checked";} ?>/> 
        </p>

            <p><label for="comentario">Comentarios:</label>
                <textarea id="comentario" name="comentarios"><?php 
                    if (isset($_POST["comentarios"])){
                        echo $_POST["comentarios"];
                    } 
                ?></textarea>
            </p>

            

            <input type="submit" name="btnEnviar" value="Enviar"/>
        </form>
    </body>
    </html>