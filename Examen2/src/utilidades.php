<?php
define("HOST", "localhost");
define("USER", "jose");
define("PWD", "josefa");
define("BD", "bd_horarios_exam");

function error_page($title,$body)
{
    $html='<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html.='<title>'.$title.'</title></head>';
    $html.='<body>'.$body.'</body></html>';
    return $html;
}

function conectarBD(){
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_horarios_exam");
        mysqli_set_charset($conexion, "UTF8");
    } catch (mysqli_sql_exception $e) {
        return $e -> getMessage();
    }
    return $conexion;
}

function imprimirHoraDia($conexion, $id_usuario, $dia, $hora){
    try {
        $consulta = "select grupos.nombre from horario_lectivo join grupos on horario_lectivo.grupo=grupos.id_grupo where horario_lectivo.usuario='$id_usuario' and horario_lectivo.dia='$dia' and horario_lectivo.hora='$hora'";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        return ("</tr></table><p>Ha ocurrido un error buscando en la BD: ".$e -> getMessage()."</p>");
    }
    $n_grupos = mysqli_num_rows($resultado);
    $texto = "<form action='index.php' method='post'>
        <input type='hidden' name='hora' value='$hora' >
        <input type='hidden' name='dia' value='$dia' >
        <input type='hidden' name='id_profesor' value='$id_usuario' >
        <button class='enlace' name='btnEditar'>Editar</button>
        </form>";
    if ($n_grupos > 1){
        print "<td>";
        $aux = "";
        while ($tupla = mysqli_fetch_assoc($resultado)){
            $aux .= $tupla["nombre"] . "/";
        }
        $aux = substr($aux, 0, strlen($aux)-1);
        print $aux . "<br> $texto";
        print "</td>";
    } else if ($n_grupos == 1){
        $tupla = mysqli_fetch_assoc($resultado);
        print "<td>".$tupla["nombre"]."<br>$texto</td>";
    } else {
        print "<td>$texto</td>";
    }
    mysqli_free_result($resultado);
}

?>