<?php
echo "<div class='centrado'><h3>Detalles del usuario con id: ".$_POST["btnDetalle"]."</h3>";
try{
    $consulta="select * from usuarios where id_usuario='".$_POST["btnDetalle"]."'";
    $resultado=mysqli_query($conexion, $consulta);
}
catch(Exception $e)
{
    mysqli_close($conexion);
    session_destroy();
    die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

if(mysqli_num_rows($resultado)>0)
{
    $datos_usuario=mysqli_fetch_assoc($resultado);
    mysqli_free_result($resultado);

    echo "<p>";
    echo "<strong>Nombre: </strong>".$datos_usuario["nombre"]."<br>";
    echo "<strong>Usuario: </strong>".$datos_usuario["usuario"]."<br>";
    echo "<strong>Email: </strong>".$datos_usuario["email"];
    echo "</p>";
}
else
    echo "<p>El usuario seleccionado ya no se encuentra registrado en la BD</p>";


echo "<form action='index.php' method='post'>";
echo "<p><button type='submit'>Volver</button></p>";
echo "</form></div>";
    ?>