<?php
class Pelicula {
    private $nombre;
    private $director;
    private $anio;
    private $precio;
    private $alquilada;
    private $fecha_prev_devolucion;
    private $recargo;

    public function __construct($nombre, $director, $anio, $precio, $alquilada, $fecha_prev_devolucion)
    {
        $this->nombre = $nombre;
        $this->director = $director;
        $this->anio = $anio;
        $this->alquilada = $alquilada;
        $this->fecha_prev_devolucion = new DateTime($fecha_prev_devolucion);
        $this->precio = $precio;
        $this->recargo = 1.2;
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

    public function getDirector()
    {
        return $this->director;
    }

    public function setDirector($director): self
    {
        $this->director = $director;

        return $this;
    }

    public function getAnio()
    {
        return $this->anio;
    }

    public function setAnio($anio): self
    {
        $this->anio = $anio;

        return $this;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getAlquilada()
    {
        return $this->alquilada;
    }

    public function setAlquilada($alquilada): self
    {
        $this->alquilada = $alquilada;

        return $this;
    }

    public function getFechaPrevDevolucion()
    {
        return $this->fecha_prev_devolucion->format("d/m/Y");
    }

    public function setFechaPrevDevolucion($fecha_prev_devolucion): self
    {
        $this->fecha_prev_devolucion = $fecha_prev_devolucion;

        return $this;
    }

    public function calcularRecargo(){
        $fecha_actual = new DateTime("now");
        $recargo = 0;

        if ($fecha_actual > $this->fecha_prev_devolucion){
            $dif_dias = $fecha_actual->diff($this->fecha_prev_devolucion);
        }

        return $recargo;
    }
}