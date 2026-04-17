<?php
Class Producto{
    private $idProducto;
    private $nombre;
    private $descripcion;
    private $existencia;
    private $precio;

    public function __construct ($idProducto = null ,$nombre = "",$descripcion = "",$existencia = 0,$precio = 0.00){
        $this->idProducto = $idProducto;
        $this->nombre = $nombre;
        $this->descripcion =$descripcion;
        $this->existencia = $existencia;
        $this->precio = $precio;
    }

    public function setidProducto($idProducto){
        $this->idProducto = $idProducto;
    }
    public function getidProducto(){
        return $this->idProducto;
    }

    public function setnombre($nombre){
        $this->nombre = $nombre;
    }
    public function getnombre(){
        return $this->nombre;
    }

    public function setdescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
    public function getdescripcion(){
        return $this->descripcion;
    }

    public function setexistencia($existencia){
        $this->existencia = $existencia;
    }
    public function getexistencia(){
        return $this->existencia;
    }

    public function setprecio($precio){
        $this->precio = $precio;
    }
    public function getprecio(){
        return $this->precio;
    }

}
?>