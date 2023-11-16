
<h3>Detalles del usuario con id: <?php print $_POST["btnDetalle"] ?></h3>
<?php
// Me conecto a la BD si no estoy conectado
if (!isset($bd)){
    $bd = conectarBD();
    if (is_string($bd)){
        die("<p>Ha ocurrido un error intentando conectarse a la BD: $bd</p>");
    }
}

// Hago la búsqueda para obtener todos los datos del usuario
try {
    $consulta = "select * from usuarios where id_usuario=". $_POST["btnDetalle"];
    $resultado = mysqli_query($bd, $consulta);
} catch (mysqli_sql_exception $e) {
    mysqli_close($bd);
    die("<p>Ha ocurrido un error intentando obtener la información del usuario: $e</p>");
}

$fila = mysqli_fetch_assoc($resultado);
mysqli_free_result($resultado);
?>
<p><strong>Nombre:</strong> <?php print $fila["nombre"] ?></p>
<p><strong>Usuario:</strong> <?php print $fila["usuario"] ?></p>
<p><strong>DNI:</strong> <?php print $fila["dni"] ?></p>
<p><strong>Sexo:</strong> <?php print $fila["sexo"] ?></p>
<p><img src="Img/<?php print $fila["foto"] ?>" class="foto-perfil" alt="Foto de perfil"></p>