<?php
session_name("examen2");
session_start();
require "src/utilidades.php";

if (isset($_POST["btnQuitar"])){ // Quito la clase de su horario a esa hora
    if(!isset($conexion)){
        $conexion = conectarBD();
        if (is_string($conexion)){
            session_destroy();
            die(error_page("Error conectando a la BD", "<h2>Ha ocurrido un error conectando a la BD</h2><p>$conexion</p>"));
        }
    }
    // Elimino de la BD
    try {
        $consulta = "delete from horario_lectivo where usuario='".$_POST["id_profesor"]."' and dia='".$_POST["dia"]."' and hora='".$_POST["hora"]."' and grupo='".$_POST["btnQuitar"]."'";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e){
        session_destroy();
        die(error_page("Error borrando en la BD", "<h2>Ha ocurrido un error borrando en la BD</h2><p>$e</p>"));
    }

    $_SESSION["id_profesor"] = $_POST["id_profesor"];
    $_SESSION["dia"] = $_POST["dia"];
    $_SESSION["hora"] = $_POST["hora"];
    $_SESSION["mensaje"] = "Grupo borrado con éxito.";
    header("Location: index.php");
    exit();
}

if (isset($_POST["btnAgregar"])){
    if(!isset($conexion)){
        $conexion = conectarBD();
        if (is_string($conexion)){
            session_destroy();
            die(error_page("Error conectando a la BD", "<h2>Ha ocurrido un error conectando a la BD</h2><p>$conexion</p>"));
        }
    }

    // Agrego a la BD
    try {
        $consulta = "insert into horario_lectivo (`usuario`, `dia`, `hora`, `grupo`) values (".$_POST["id_profesor"].", ".$_POST["dia"].", ".$_POST["hora"].",".$_POST["grupo"].")";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e){
        session_destroy();
        die(error_page("Error borrando en la BD", "<h2>Ha ocurrido un error borrando en la BD</h2><p>$e</p>"));
    }

    $_SESSION["id_profesor"] = $_POST["id_profesor"];
    $_SESSION["dia"] = $_POST["dia"];
    $_SESSION["hora"] = $_POST["hora"];
    $_SESSION["mensaje"] = "Grupo insertado con éxito.";
    header("Location: index.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP</title>
    <style>
        table {
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid black;
            text-align: center;
        }

        th {
            background-color: lightgrey;
        }

        .enlace {
            background-color: white;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>
    <form action="index.php" method="post">
        <?php
        if (isset($_POST["btnVer"])){
            $id_usuario = $_POST["profesor"];
        } else if (isset($_POST["btnEditar"]) || isset($_SESSION["id_profesor"])) {
            $id_usuario = $_SESSION["id_profesor"];
        }
        // Me conecto a la BD si no estoy conectado
        if (!isset($conexion)) {
            $conexion = conectarBD();
            if (is_string($conexion)) {
                session_destroy();
                die("<p>Ha ocurrido un error conectando a la BD: $conexion</p>");
            }
        }
        // Busco los profesores
        try {
            $consulta = "select * from usuarios";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die("<p>Ha ocurrido un error buscando en la BD: $e</p>");
        }

        print "<p>Horario del Profesor:";
        print "<select name='profesor'>";
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            if (isset($_POST["btnVer"]) || isset($_POST["btnEditar"]) && $tupla["id_usuario"] == $id_usuario){
                print "<option selected value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
                $_SESSION["profesor"] = $tupla["nombre"];
            } else {
                print "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
            }
        }
        print "</select>";
        print "<button name='btnVer'>Ver Horario</button>";
        print "</p>";
        mysqli_free_result($resultado);
        ?>
    </form>
    <?php
    if (isset($_POST["btnVer"]) || isset($_POST["btnEditar"]) || isset($_SESSION["id_profesor"])) {
        

        // Me conecto a la BD si no estoy conectado
        if (!isset($conexion)) {
            $conexion = conectarBD();
            if (is_string($conexion)) {
                session_destroy();
                die("<p>Ha ocurrido un error conectando a la BD: $conexion</p>");
            }
        }
        // Busco el horario del profesor seleccionado
        
        
        // Creo la tabla
        print "<table>";
        print "<caption><strong>Horario del Profesor: <em> ".$_SESSION["profesor"]."</em></strong></caption>";
        // Imprimo la cabecera
        print "<tr>";
        print "<th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th>";
        print "</tr>";
        // Imprimo el horario del profesor
        // Imprimo la primera hora del lunes
        print "<tr>";
        print "<th>8:15 - 9:15</th>";
        $var = imprimirHoraDia($conexion, $id_usuario, 1, 1);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 2, 1);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 3, 1);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 4, 1);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 5, 1);
        if (is_string($var)){
            die($var);
        }
        print "</tr>";
        // Segunda
        print "<tr>";
        print "<th>9:15 - 10:15</th>";
        $var = imprimirHoraDia($conexion, $id_usuario, 1, 2);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 2, 2);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 3, 2);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 4, 2);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 5, 2);
        if (is_string($var)){
            die($var);
        }
        print "</tr>";
        // Tercera
        print "<tr>";
        print "<th>10:15 - 11:15</th>";
        $var = imprimirHoraDia($conexion, $id_usuario, 1, 3);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 2, 3);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 3, 3);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 4, 3);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 5, 3);
        if (is_string($var)){
            die($var);
        }
        print "</tr>";
        // Cuarta
        print "<tr>";
        print "<th>11:15 - 11:45</th>";
        print "<td colspan='5'>Recreo</td>";

        print "</tr>";
        // Quinta
        print "<tr>";
        print "<th>11:45 - 12:45</th>";
        $var = imprimirHoraDia($conexion, $id_usuario, 1, 5);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 2, 5);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 3, 5);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 4, 5);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 5, 5);
        if (is_string($var)){
            die($var);
        }
        print "</tr>";
        // Sexta
        print "<tr>";
        print "<th>12:45 - 13:45</th>";
        $var = imprimirHoraDia($conexion, $id_usuario, 1, 6);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 2, 6);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 3, 6);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 4, 6);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 5, 6);
        if (is_string($var)){
            die($var);
        }
        print "</tr>";
        // Septima
        print "<tr>";
        print "<th>13:45 - 14:45</th>";
        $var = imprimirHoraDia($conexion, $id_usuario, 1, 7);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 2, 7);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 3, 7);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 4, 7);
        if (is_string($var)){
            die($var);
        }
        $var = imprimirHoraDia($conexion, $id_usuario, 5, 7);
        if (is_string($var)){
            die($var);
        }
        print "</tr>";
        print "</table>";
        if (isset($_POST["btnEditar"]) ||  isset($_SESSION["id_profesor"])){
            $horas = array(1 => "8:15 - 9:15", 2 => "9:15 - 10:15", 3 => "10:15 - 11:15", 4 => "11:15 - 11:45", 5 => "11:45 - 12:45", 6 => "12:45 - 13:45", 7 => "13:45 - 14:45");
            $dias = array(1 => "Lunes", 2 => "Martes", 3 => "Miércoles", 4 => "Jueves", 5 => "Viernes");
            $dia = isset($_POST["dia"]) ? $_POST["dia"]:$_SESSION["dia"];
            $hora = isset($_POST["hora"]) ? $_POST["hora"]:$_SESSION["hora"];

            print "<h3>Editando la ".$hora."º hora (".$horas[$hora].") del ".$dias[$dia]."</h3>";
            if (isset($_SESSION["mensaje"])){
                print "<p>".$_SESSION["mensaje"]."</p>";
                unset($_SESSION["mensaje"]);
            }

            // Hago la tabla para editar
            print "<table>";
            print "<tr><th>Grupo</th><th>Acción</th></tr>";
            try { // Busco los grupos de esa hora y ese dia
                $consulta = "select grupos.nombre, grupos.id_grupo from horario_lectivo join grupos on horario_lectivo.grupo=grupos.id_grupo where horario_lectivo.usuario='$id_usuario' and horario_lectivo.dia='$dia' and horario_lectivo.hora='$hora'";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                die("</table><p>Ha ocurrido un error buscando en la BD: ".$e -> getMessage()."</p>");
            }

            $texto = "<form action='index.php' method='post'>
        <input type='hidden' name='hora' value='$hora' >
        <input type='hidden' name='dia' value='$dia' >
        <input type='hidden' name='id_profesor' value='$id_usuario' >";
            while ($tupla = mysqli_fetch_assoc($resultado)){
                print "<tr>";
                print "<td>".$tupla["nombre"]."</td>";
                print "<td>$texto<button class='enlace' name='btnQuitar' value='".$tupla["id_grupo"]."' >Quitar</button></form></td>";
                print "</tr>";
            }
            mysqli_free_result($resultado);
            print "</table>";

            // Hago el añadir
            try { // Busco los grupos de esa hora y ese dia
                $consulta = "select grupos.nombre, id_grupo from horario_lectivo join grupos on horario_lectivo.grupo=grupos.id_grupo where usuario='$id_usuario'";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                die("<p>Ha ocurrido un error buscando en la BD: ".$e -> getMessage()."</p>");
            }
            print "<br><form>";
            print "<select name='idGrupo'>";
            while ($tupla = mysqli_fetch_assoc($resultado)){
                print "<option value='".$tupla["id_grupo"]."'>".$tupla["nombre"]."</option>";
            }
            print "</select>";
            $texto = "
        <input type='hidden' name='hora' value='$hora' >
        <input type='hidden' name='dia' value='$dia' >
        <input type='hidden' name='id_profesor' value='$id_usuario' >
        <button name='btnAgregar'>Añadir</button>
        ";
            
            print $texto;
            print "</form>";

        }
    }
    ?>


    <?php
    mysqli_close($conexion);
    ?>
</body>

</html>