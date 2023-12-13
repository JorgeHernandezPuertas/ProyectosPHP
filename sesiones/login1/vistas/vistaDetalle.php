<?php
print "<h4>Detalles del usuario</h4>";

try {
    $consulta = "select * from usuarios where id_usuario='".$_POST["btnDetalle"]."'";
    $resultado = mysqli_query($conexion, $consulta);
} catch (mysqli_sql_exception $e) {
    mysqli_close($conexion);
    die("<p>Ha ocurrido un error buscando en la BD: $e</p>");
}

if (mysqli_num_rows($resultado) > 0){
    $tupla = mysqli_fetch_assoc($resultado);
    print "<p><strong>Nombre: </strong>".$tupla["nombre"]."</p>";
    print "<p><strong>Usuario: </strong>".$tupla["usuario"]."</p>";
    print "<p><strong>Email: </strong>".$tupla["email"]."</p>";
    print "<p><strong>Tipo: </strong>".$tupla["tipo"]."</p>";
} else {
    print "<p>El usuario seleccionado ya no se encuentra en la BD.</p>";
}
mysqli_free_result($resultado);



?>