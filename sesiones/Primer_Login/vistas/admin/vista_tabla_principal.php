<?php
try{
        $consulta="select * from usuarios where tipo<>'admin'";
        $resultado=mysqli_query($conexion, $consulta);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        session_destroy();
        die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
    }
    
    echo "<h2 class='txt_centrado'>Listado de los usuarios (no admin)</h2>";
    echo "<table id='tb_principal' class='txt_centrado centrado'>";
    echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th><th><form action='index.php' method='post'><button class='enlace grande' type='submit' name='btnNuevo'>+</button></form></th></tr>";
    while($tupla=mysqli_fetch_assoc($resultado))
    {
        echo "<tr>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnDetalle' title='Detalles del Usuario'>".$tupla["nombre"]."</button></form></td>";
        echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='".$tupla["nombre"]."'><button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnBorrar'><img src='images/borrar.png' alt='Imagen de Borrar' title='Borrar Usuario'></button></form></td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnEditar'><img src='images/editar.png' alt='Imagen de Editar' title='Editar Usuario'></button></form></td>";
        echo "<td class='no_bordes'></td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($resultado);

    if(isset($_SESSION["mensaje"]))
    {
        echo "<p class='mensaje centrado'>".$_SESSION["mensaje"]."</p>";
        unset($_SESSION["mensaje"]);
    }
?>