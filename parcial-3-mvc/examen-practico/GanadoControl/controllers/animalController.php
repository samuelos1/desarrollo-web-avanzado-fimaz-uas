<?php
    //Incluimos el archivo animal model del Modelo
    require_once("../../models/animalModel.php");

    class animalController{

        private $model;

        public function __construct()
        {
            $this->model = new animalModel();
        }

        //Método controlador para guardar un animal.
        public function saveAnimal($nombre, $sexo, $raza, $edad, $peso, $vacunas, $dueno,
        $fechaNacimiento, $usuario, $contrasena){
            $id = $this->model->insert($nombre, $sexo, $raza, $edad, $peso, $vacunas, $dueno,
            $fechaNacimiento, $usuario, $contrasena);
            return ($id != false) ? header("Location: admin.php") : header("Location: frmAnimal.php");
        }

        //Método para ejecutar la función read del modelo.
        public function readAnimales(){
            return ($this->model->read()) ? $this->model->read() : false;
        }

        //Método para ejecutar la función readOne del modelo.
        public function readOneAnimal($id){
            return ($this->model->readOne($id) != false) ? $this->model->readOne($id) : header
            ("Location: admin.php");
        }

        //Método que manda llamar la función update del modelo.
        public function updateAnimal($id, $nombre, $sexo, $raza, $edad, $peso, $vacunas,
        $dueno, $fechaNacimiento){
            return ($this->model->update($id, $nombre, $sexo, $raza, $edad, $peso, $vacunas,
            $dueno, $fechaNacimiento) != false) ? header("Location: readOneAnimal.php?id=".$id)
            : header("Location: readAllAnimales.php");
        }

        //Método que manda llamar la función delete del modelo.
        public function delete($id){
            return ($this->model->delete($id) != false) ? header("Location: readAllAnimales.php")
            : header("Location: admin.php");
        }

    }

?>
