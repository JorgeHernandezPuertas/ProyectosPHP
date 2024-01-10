<?php
// Creo la clase fruta
class Fruta {
    private static $n_frutas = 0;
    private $color;
    private $tamanio;

    public function __construct ($color, $tamanio) {
        $this->color = $color;
        $this->tamanio = $tamanio;
        self::$n_frutas++;
    }

    public function __destruct()
    {
        self::$n_frutas--;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getTamanio()
    {
        return $this->tamanio;
    }

    public function setTamanio($tamanio): self
    {
        $this->tamanio = $tamanio;

        return $this;
    }

    public static function cuantaFruta(){
        return self::$n_frutas;
    }

    public function imprimir()
    {
        print "<p>Esta es una fruta de color ".$this->getColor()." y de tamaño ".$this->getTamanio()."</p>";
    }
}
?>
