<?php
session_name("Examen2_22_23");
session_start();

function error_page($title,$body)
{
    $page='<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title>
    </head>
    <body>'.$body.'</body>
    </html>';
    return $page;
}

if(isset($_POST["btnCambiarNota"]))
{
    $error_form=$_POST["nota"]==""||!is_numeric($_POST["nota"]) || $_POST["nota"]<0 ||$_POST["nota"]>10;
    if(!$error_form)
    {
        try{
            $conexion=mysqli_connect("localhost","jose","josefa","bd_exam_colegio");
            mysqli_set_charset($conexion,"utf8");
        }
        catch(Exception $e)
        {
            session_destroy();
            die(error_page("Examen2 DWESE 22-23","<h1>Notas de los Alumnos</h1><p>No se ha podido conectar a la BD: ".$e->getMessage()."</p>"));
        }

        try{
            $consulta="update notas set nota='".$_POST["nota"]."' where cod_asig='".$_POST["btnCambiarNota"]."' and cod_alu='".$_POST["alumno"]."'";
            $resultado=mysqli_query($conexion,$consulta);
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            session_destroy();
            die(error_page("Examen2 DWESE 22-23","<h1>Notas de los Alumnos</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
        }

        $_SESSION["mensaje"]="Nota cambiada con éxito";
        $_SESSION["alumno"]=$_POST["alumno"];
        header("Location:index.php");
        exit;
    }
}

if(isset($_POST["btnBorrarNota"]))
{
    
    try{
        $conexion=mysqli_connect("localhost","jose","josefa","bd_exam_colegio");
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        session_destroy();
        die(error_page("Examen2 DWESE 22-23","<h1>Notas de los Alumnos</h1><p>No se ha podido conectar a la BD: ".$e->getMessage()."</p>"));
    }

    try{
        $consulta="delete from notas where cod_asig='".$_POST["btnBorrarNota"]."' and cod_alu='".$_POST["alumno"]."'";
        $resultado=mysqli_query($conexion,$consulta);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        session_destroy();
        die(error_page("Examen2 DWESE 22-23","<h1>Notas de los Alumnos</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
    }

    $_SESSION["mensaje"]="Nota borrado con éxito";
    $_SESSION["alumno"]=$_POST["alumno"];
    header("Location:index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 DWESE 22-23</title>
</head>
<body>
    <h1>Notas de los Alumnos</h1>
    <?php
    if(!isset($conexion))
    {
        try{
            $conexion=mysqli_connect("localhost","jose","josefa","bd_exam_colegio");
            mysqli_set_charset($conexion,"utf8");
        }
        catch(Exception $e)
        {
            die("<p>No se ha podido conectar a la base de batos: ".$e->getMessage()."</p></body></html>");
        }
    }
    try{
        $consulta="select * from alumnos";
        $resultado=mysqli_query($conexion,$consulta);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
    }
    
    if(mysqli_num_rows($resultado)>0)
    {
        //Por aquí va el examen principal
    ?>    
        <form action="index.php" method="post">
            <p>
                <label for="alumno">Seleccione un alumno: </label>
                <select name="alumno" id="alumno">
                <?php
                while($datos_alumno=mysqli_fetch_assoc($resultado))
                {
                    if((isset($_POST["alumno"]) && $_POST["alumno"]==$datos_alumno["cod_alu"]) ||(isset($_SESSION["alumno"]) && $_SESSION["alumno"]==$datos_alumno["cod_alu"]) )
                    {
                        echo "<option selected value='".$datos_alumno["cod_alu"]."'>".$datos_alumno["nombre"]."</option>";
                        $nombre_alumno=$datos_alumno["nombre"];
                    }
                    else
                        echo "<option value='".$datos_alumno["cod_alu"]."'>".$datos_alumno["nombre"]."</option>";
                }
                ?>
                </select>
                <button type="submit" name="btnVerNotas">Ver Notas</button>
            </p>
        </form>
    <?php 
        if(isset($_POST["alumno"]) || isset($_SESSION["alumno"]) )
        {
            if(isset($_SESSION["alumno"]))
                $cod_alu=$_SESSION["alumno"];
            else
                $cod_alu=$_POST["alumno"];

            echo "<h2>Notas del alumno ".$nombre_alumno."</h2>";
            ///Por aquí continuamos
            //select asignaturas.cod_asig, asignaturas.denominacion, notas.nota from asignaturas, notas where asignaturas.cod_asig=notas.cod_asig and notas.cod_alu=2
            //select * from asignaturas where cod_asig not in (select asignaturas.cod_asig from asignaturas, notas where asignaturas.cod_asig=notas.cod_asig and notas.cod_alu=2);

            try{
                $consulta="select asignaturas.cod_asig, asignaturas.denominacion, notas.nota from asignaturas, notas where asignaturas.cod_asig=notas.cod_asig and notas.cod_alu='".$cod_alu."'";
                $resultado=mysqli_query($conexion,$consulta);
            }
            catch(Exception $e)
            {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
            }

            echo "<table border='1'>";
            echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
            while($tupla=mysqli_fetch_assoc($resultado))
            {
                echo "<tr>";
                echo "<td>".$tupla["denominacion"]."</td>";
                if((isset($_POST["btnEditarNota"]) && $_POST["btnEditarNota"]==$tupla["cod_asig"]) || (isset($_POST["btnCambiarNota"]) && $_POST["btnCambiarNota"]==$tupla["cod_asig"]) )
                {
                    if(isset($_POST["btnEditarNota"]))
                        $nota=$tupla["nota"];
                    else
                        $nota=$_POST["nota"];

                    echo "<td><form action='index.php' method='post'><input type='text' name='nota' value='".$nota."'>";
                    if(isset($_POST["nota"])&& $error_form)
                        echo "<br><span class='error'>No has introducido una nota válida</span>";
                    echo "</td>";
                    echo "<td><input type='hidden' name='alumno' value='".$cod_alu."'><button type='submit' name='btnCambiarNota' value='".$tupla["cod_asig"]."'>Cambiar</button> - <button type='submit' >Atrás</button></form></td>";
                }
                else
                {
                    echo "<td>".$tupla["nota"]."</td>";
                    echo "<td><form action='index.php' method='post'><input type='hidden' name='alumno' value='".$cod_alu."'><button type='submit' name='btnBorrarNota' value='".$tupla["cod_asig"]."'>Borrar</button> - <button type='submit' name='btnEditarNota' value='".$tupla["cod_asig"]."'>Editar</button></form></td>";
                }
                echo "</tr>";
            }
            echo "</table>";

            if(isset($_SESSION["mensaje"]))
            {
                echo "<p class=''>".$_SESSION["mensaje"]."</p>";
                session_destroy();
            }

            try{
                $consulta="select * from asignaturas where cod_asig not in (select asignaturas.cod_asig from asignaturas, notas where asignaturas.cod_asig=notas.cod_asig and notas.cod_alu='".$cod_alu."')";
                $resultado=mysqli_query($conexion,$consulta);
            }
            catch(Exception $e)
            {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
            }
            if(mysqli_num_rows($resultado)>0)
            {
            ?>
                <form action="index.php" method="post">
                    <p>
                        <label for="asignatura">Asignaturas que le quedan a <?php echo $nombre_alumno;?> por calificar:</label>
                        <input type="hidden" name="alumno" value="<?php echo $cod_alu;?>">
                        <select name="asignatura" id="asignatura">
                         <?php
                         while ($tupla=mysqli_fetch_assoc($resultado))
                         {
                            echo "<option value='".$tupla["cod_asig"]."'>".$tupla["denominacion"]."</option>";
                         }
                         ?>
                        </select>
                        <button type="submit" name="btnCalificar">Calificar</button>
                    </p>
                </form>
            <?php
            }
            else
                echo "<p>A ".$nombre_alumno." no le quedan asignaturas por calificar.</p>";
        }
    }
    else
        echo "<p>En estos momentos no tenemos ningún alumno registrado en la BD</p>";

    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>
</html>