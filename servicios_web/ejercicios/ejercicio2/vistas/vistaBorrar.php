<div>
  <form action="index.php" method="post">
    ¿Seguro que quieres borrar el producto con código <strong><?php print $_POST["btnBorrar"] ?></strong>?
    <button value="<?php print $_POST["btnBorrar"] ?>" name="btnContBorrar">Borrar</button> <button name='btnVolver'>Volver</button>
  </form>
</div>