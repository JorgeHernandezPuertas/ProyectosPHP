<?php
// Busco los usuarios y los listo
try {
    $consulta = "select * from usuarios where tipo='normal'";
    $resultado = mysqli_query($conexion, $consulta);
} catch (mysqli_sql_exception $e) {
    mysqli_close($conexion);
    die("<p>Ha ocurrido un error buscando en la BD: $e</p>");
}

print "<table>";
print "<caption><strong>Lista de usuarios (no admins)<strong></caption>";
print "<tr>";
print "<th>Nombre de usuario</th><th>Borrar</th><th>Editar</th><th><form action='index.php' method='post'><button class='enlace'> + </button></form></th>";
print "</tr>";
while ($tupla = mysqli_fetch_assoc($resultado)) {
    print "<tr>";
    print "<td><form action='index.php' method='post'><button name='btnDetalle' class='enlace' value='" . $tupla["id_usuario"] . "'>" . $tupla["usuario"] . "</button></form></td>";
    print "<td><form action='index.php' method='post'><button class='tabla' value='" . $tupla["id_usuario"] . "' ><img src='images/borrar.png' alt='Borrar' title='Borrar' ></button></form></td>";
    print "<td><form action='index.php' method='post'><button class='tabla' value='" . $tupla["id_usuario"] . "'><img src='images/modificar.png' alt='Editar' title='Editar' ></button></form></td>";
    print "<td></td>";
    print "</tr>";
}
print "</table>";
mysqli_free_result($resultado);
