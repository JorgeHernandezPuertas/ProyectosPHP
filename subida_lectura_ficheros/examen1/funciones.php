<?php
function mi_explode_sin_vocales($sep, $texto)
{
    $palabras = [];
    for ($i = 0; $i < strlen($texto); $i++) {
        while ($i < strlen($texto) && $sep == $texto[$i]) {
            $i++; // Paso el puntero por los separadores
        }

        while ($i < strlen($texto) && $texto[$i] != $sep) {
            if (es_vocal($texto[$i])) {
                // Si encuentro vocal en la palabra, la elimino y sigo hasta encontrar un sep
                unset($palabra);
                while ($i < strlen($texto) && $texto[$i] != $sep) {
                    $i++;
                }
            } else {
                if (isset($palabra)) {
                    $palabra .= $texto[$i];
                    $i++;
                } else {
                    $palabra = $texto[$i];
                    $i++;
                }
            }
        }
        if (isset($palabra)) {
            $palabras[] = $palabra;
            unset($palabra);
        }
    }
    return $palabras;
}

function es_vocal($letra)
{
    $vocales = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U");
    $es_letra = false;
    foreach ($vocales as $vocal) {
        if ($letra == $vocal) {
            $es_letra = true;
            break;
        }
    }
    return $es_letra;
}

function mi_explode($sep, $texto){
    $palabras = [];
    for ($i = 0; $i < strlen($texto); $i++) {
        while ($i < strlen($texto) && $sep == $texto[$i]) {
            $i++; // Paso el puntero por los separadores
        }

        while ($i < strlen($texto) && $texto[$i] != $sep) {
            if (isset($palabra)) {
                $palabra .= $texto[$i];
                $i++;
            } else {
                $palabra = $texto[$i];
                $i++;
            }
        }
        if (isset($palabra)) {
            $palabras[] = $palabra;
            unset($palabra);
        }
    }
    return $palabras;
}

function es_txt($nombre_archivo){
    $es_txt = false;
    $elementos = mi_explode(".", $nombre_archivo);
    if (count($elementos) > 0){
        $ext = $elementos[count($elementos) - 1];
        if ($ext == "txt"){
            $es_txt = true;
        }
    }
    return $es_txt;
    
}

function esta_matriz($elemento, $matriz){
    for ($i=0; $i < count($matriz); $i++) {
        if ($matriz[$i][0] == $elemento){
            return $i;
        }
    }
    return -1;
}


?>