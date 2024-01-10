<?php
require "class_fruta.php";
class Uva extends Fruta {
    private $tieneSemilla;

    public function __construct($color, $tamanio, $tieneSemilla){
        parent::__construct($color, $tamanio);
        $this->tieneSemilla = $tieneSemilla;
    }

    public function tieneSemilla(){
        return $this->tieneSemilla;
    }
}