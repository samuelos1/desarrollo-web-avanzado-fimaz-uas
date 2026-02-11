<?php

interface Saludable {
    public function saludar(): string;
}

class Persona implements Saludable {
    protected string $nombre;

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }

    public function saludar(): string {
        return "Hola, soy " . $this->nombre;
    }
}

class Estudiante extends Persona {
    private string $carrera;

    public function __construct(string $nombre, string $carrera) {
        parent::__construct($nombre);
        $this->carrera = $carrera;
    }

    public function mostrarCarrera(): string {
        return "Estudio " . $this->carrera;
    }
}

try {
    $est = new Estudiante("Juan", "LISI");
    echo $est->saludar() . "<br>";
    echo $est->mostrarCarrera();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
