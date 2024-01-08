<?php
print "<p>Se dispone usted a borrar la caratula de la película con id = " . $_POST["eliminarCar"] . "</p>";
print "<p>Cambiará esta carátula: <img src='Img/" . $_POST["fotoAnt"] . "' >  por esta otra: <img src='Img/no_imagen.jpg' ></p>";
print "<form action='index.php' method='post' ><input type='hidden' name='fotoAnt' value='" . $_POST["fotoAnt"] . "' >";
print "<button name='btnContBorrarCar' value='" . $_POST["eliminarCar"] . "'>Continuar</button><button>Atrás</button></form>";
