<?php
    function mi_strlen($palabra){
            $contador = 0;
            while(isset($palabra[$contador])){
                $contador++;
            }
            return $contador;
    }

    function mi_explode($separador, $palabra){
        $indices_sep = []; 
        for ($i=0; $i < mi_strlen($palabra); $i++) { 
            if ($palabra[$i] == $separador){
                $indices_sep[] = $i;
            }
        }

        $palabra_separada = [];

        for ($i=0; $i < count($indices_sep); $i++) {
            if ($i == 0){
                if ($i == count($indices_sep) - 1){
                    $elemento = "";
                for ($j=0; $j < $indices_sep[$i]; $j++) { 
                    $elemento .= $palabra[$j];
                }
                $palabra_separada[] = $elemento;

                $elemento = "";
                for ($j=$indices_sep[$i] + 1; $j < mi_strlen($palabra); $j++) { 
                    $elemento .= $palabra[$j];
                }
                $palabra_separada[] = $elemento;
                } else {
                    $elemento = "";
                    for ($j=0; $j < $indices_sep[$i]; $j++) { 
                        $elemento .= $palabra[$j];
                    }
                    $palabra_separada[] = $elemento;
                }
            } else {
                if ($i == count($indices_sep) - 1){
                    $elemento = "";
                    for ($j=$indices_sep[$i - 1] + 1; $j < $indices_sep[$i]; $j++) { 
                        $elemento .= $palabra[$j];
                    }
                    $palabra_separada[] = $elemento;

                    $elemento = "";
                for ($j=$indices_sep[$i] + 1; $j < mi_strlen($palabra); $j++) { 
                    $elemento .= $palabra[$j];
                }
                $palabra_separada[] = $elemento;
                } else {
                    $elemento = "";
                    for ($j=$indices_sep[$i - 1] + 1; $j < $indices_sep[$i]; $j++) { 
                        $elemento .= $palabra[$j];
                    }
                    $palabra_separada[] = $elemento;
                }
                
            }
        }

        return $palabra_separada;

    }

    function quitarElemento($palabra, $indice){
        $nueva_palabra = "";
        for ($i=0; $i < mi_strlen($palabra); $i++) { 
            if ($indice != $i){
                $nueva_palabra .= $palabra[$i];
            }
        }
        return $nueva_palabra;
    }

    function ejemplo($sep, $texto){ // Como lo ha hecho el profesor pero simplificado
        $aux=[];
        $l_texto=mi_strlen($texto);

        for ($i=0; $i < $l_texto; $i++) { 
            while ($i < $l_texto && $texto[$i] == $sep){
                $i++;
            }
            if ($i < $l_texto){ // Si no he acabado
                $aux2 = "";
                for ($j=$i; $j < $l_texto; $j++) { 
                    if ($texto[$j] != $sep){
                        $aux2 .= $texto[$j];
                    } else {
                        break;
                    }
                }
                $i = $j;
                $aux[] = $aux2; // Meto la palabra entera
            }
        }

        return $aux;
    }
?>