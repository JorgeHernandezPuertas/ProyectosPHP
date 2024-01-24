<?php
$cod = isset($_POST["btnEditar"]) ? $_POST["btnEditar"] : $_POST["btnContEditar"];
$url = DIR_SERV . "/familias";
$respuesta = consumir_servicios_REST($url, "get");
$obj = json_decode($respuesta);
if (!$obj) die("<p>Ha ocurrido un error recuperando las familias por parte del servicio: $url</p></body></html>");
if (isset($obj->mensaje_error)) die("<p>Ha ocurrido un error recuperando los productos por parte del servicio: $url <br/> Error: " . $obj->mensaje_error . "</p></body></html>");
?>
<div>
  <form action='index.php' method='post'>
    <h3>Editando el producto con código <?php print $cod ?></h3>
    <p>
      <label for='nom'>Nombre: </label>
      <input name='nom' id='nom' type='text' value="<?php if (isset($_POST["btnContEditar"])) print $_POST["nom"] ?>" />
      <?php
      if (isset($_POST["btnContEditar"]) && $error_nombre) {
        print "<span class='error'> * El nombre introducido supera el máximo de carácteres (200) * </span>";
      }
      ?>
    </p>
    <p>
      <label for='nomCor'>Nombre corto: </label>
      <input name='nomCor' id='nomCor' type='text' value="<?php if (isset($_POST["btnContEditar"])) print $_POST["nomCor"] ?>" />
      <?php
      if (isset($_POST["btnContEditar"]) && $error_nom_cor) {
        if ($_POST["nomCor"] == "") {
          print "<span class='error'> * Campo vacío * </span>";
        } else if (strlen($_POST["nomCor"]) > 50) {
          print "<span class='error'> * El nombre corto introducido supera el máximo de carácteres (50) * </span>";
        } else {
          print "<span class='error'> * El nombre corto introducido ya está en uso en la BD  * </span>";
        }
      }
      ?>
    </p>
    <p>
      <label for='desc'>Descripcion: </label>
      <textarea name='desc' id='desc'><?php if (isset($_POST["btnContEditar"])) print $_POST["desc"] ?></textarea>
      <?php
      if (isset($_POST["btnContEditar"]) && $error_descripcion) {
        print "<span class='error'> * La descripción introducida supera el máximo de carácteres (500) * </span>";
      }
      ?>
    </p>
    <p>
      <label for='pvp'>PVP: </label>
      <input name='pvp' id='pvp' type='text' value="<?php if (isset($_POST["btnContEditar"])) print $_POST["pvp"] ?>" />
      <?php
      if (isset($_POST["btnContEditar"]) && $error_pvp) {
        if ($_POST["pvp"] == "") {
          print "<span class='error'> * Campo vacío * </span>";
        } else if (!is_numeric($_POST["pvp"])) {
          print "<span class='error'> * El PVP introducido no es un número * </span>";
        } else {
          print "<span class='error'> * El  PVP introducido no cumple el formato correcto (decimal(10,2)) * </span>";
        }
      }
      ?>
    </p>
    <p>
      <label for='fam'>Seleccione una familia: </label>
      <select name='fam' id='fam'>
        <?php
        foreach ($obj->familias as $tupla) {
          $option = isset($_POST["btnContEditar"]) && $_POST["fam"] == $tupla->cod ? "<option selected value='" . $tupla->cod . "'>" . $tupla->nombre . "</option>" : "<option value='" . $tupla->cod . "'>" . $tupla->nombre . "</option>";
          print $option;
        }
        ?>
      </select>
    </p>
    <button name='btnVolver'>Volver</button> <button name='btnContEditar' value='<?php print $cod ?>'>Continuar</button>
  </form>
</div>