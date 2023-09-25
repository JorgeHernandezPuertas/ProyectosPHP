<?php
    function en_array($valor, $arr){
        $esta = false;
        foreach($arr as $aux){
            if ($aux == $valor){
                $esta = true;
                break;
            }
        }
        return $esta;
    }
?>