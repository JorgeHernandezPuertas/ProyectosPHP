<?php
class Menu {
    private $elementos;

    public function __construct(){
        $this->elementos = [];
    }

    public function cargar($url, $titulo){
        $this->elementos[$titulo] = $url;
    }

    public function imprimirHorizontal(){
        $menu = "<p>";
        foreach ($this->elementos as $titulo => $url) {
            $menu .= "<a href='$url'>$titulo</a> - ";
        }
        $menu = substr($menu, 0, -2);
        $menu .= "</p>";
        print $menu;
    }

    public function imprimirVertical(){
        $menu = "";
        foreach ($this->elementos as $titulo => $url) { 
            $menu .= "<a href='$url'>$titulo</a><br/>";
        }
        print $menu;
    }
}