<?php
class Empleado {
    private $nombre;
    private $sueldo;

    public function __construct($nombre, $sueldo){
        $this->nombre = $nombre;
        $this->sueldo = $sueldo;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getSueldo()
    {
        return $this->sueldo;
    }

    public function setSueldo($sueldo): self
    {
        $this->sueldo = $sueldo;

        return $this;
    }

    public function imprimir(){
        $texto = $this->sueldo > 3000 ? "El empleado se llama ".$this->nombre." y tiene que pagar impuestos.":"El empleado se llama ".$this->nombre." y no tiene que pagar impuestos.";
        print "<p>$texto</p>";
    }
}