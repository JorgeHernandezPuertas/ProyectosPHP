<h4>Insertar nuevo usuario</h4>
<form action="index.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="titulo">Título: </label><br>
        <input type="text" name="titulo" id="titulo" value="<?php if (isset($_POST["btnInsertarConf"])) print $_POST["titulo"] ?>">
        <?php
        if (isset($_POST["btnInsertarConf"]) && $error_titulo) {
            if ($_POST["titulo"] == "") {
                print "<span class='error' > * Campo obligatorio * </span>";
            } else {
                print "<span class='error' > * Has superado el número máximo de caracteres (15) * </span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="director">Director: </label><br>
        <input type="text" name="director" id="director" value="<?php if (isset($_POST["btnInsertarConf"])) print $_POST["director"] ?>" >
        <?php
        if (isset($_POST["btnInsertarConf"]) && $error_director) {
            if ($_POST["director"] == "") {
                print "<span class='error' > * Campo obligatorio * </span>";
            } else {
                print "<span class='error' > * Has superado el número máximo de caracteres (20) * </span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="sinopsis">Sinopsis:</label><br>
        <textarea name="sinopsis" id="sinopsis" cols="20" rows="5"><?php if (isset($_POST["btnInsertarConf"])) print $_POST["sinopsis"] ?></textarea>
        <?php
        if (isset($_POST["btnInsertarConf"]) && $error_sinopsis) {
            print "<span class='error' > * Campo obligatorio * </span>";
        }
        ?>
    </p>
    <p>
        <label for="tematica">Temática:</label><br>
        <input type="text" name="tematica" id="tematica" value="<?php if (isset($_POST["btnInsertarConf"])) print $_POST["tematica"] ?>">
        <?php
        if (isset($_POST["btnInsertarConf"]) && $error_tematica) {
            if ($_POST["tematica"] == "") {
                print "<span class='error' > * Campo obligatorio * </span>";
            } else {
                print "<span class='error' > * Has superado el número máximo de caracteres (15) * </span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="caratula">Carátula: </label><br>
        <input type="file" name="caratula" id="caratula" accept="image/*">
        <?php
        if (isset($_POST["btnInsertarConf"]) && $error_caratula) {
            if (!getimagesize($_FILES["caratula"]["tmp_name"])){
                print "<span class='error'> * El archivo subido no es una imagen * </span>";
            } else {
                print "<span class='error'> * La imagen tiene que tener una extensión * </span>";
            }
        }
        ?>
    </p>
    <button name="btnInsertarConf">Insertar</button> <button>Atrás</button>
</form>