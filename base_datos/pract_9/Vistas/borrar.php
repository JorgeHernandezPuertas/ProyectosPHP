<?php

?>
<h4>Borrando la película con id: <?php print $_POST["btnBorrar"] ?></h4>
<p>¿Estás seguro que quieres borrar la película <strong><?php print $_POST["btnBorrar"] ?></strong>?</p>
<form action="index.php" method="post" >
    <input type="hidden" name="fotoAnt" value="<?php print $_POST["fotoAnt"] ?>">
<button name="btnBorrarCont" value="<?php print $_POST["btnBorrar"] ?>">Sí</button> <button>No</button>
</form>