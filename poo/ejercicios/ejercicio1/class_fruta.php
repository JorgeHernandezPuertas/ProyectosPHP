<?php
// Creo la clase fruta
class Fruta {
    private $color;
    private $tamanio;

    public function __construct () {
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
}
?>
