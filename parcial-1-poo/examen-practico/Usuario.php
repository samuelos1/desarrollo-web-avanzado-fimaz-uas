<?php
class Usuario {
    private $nombre;
    private $correo;

    public function __construct($nombre, $correo) {
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Correo no válido");
        }
        $this->nombre = $nombre;
        $this->correo = $correo;
    }

    public function getNombre() { return $this->nombre; }
    public function getCorreo() { return $this->correo; }
}
?>