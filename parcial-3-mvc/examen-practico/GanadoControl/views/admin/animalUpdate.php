<?php
    require_once("../../controllers/animalController.php");

    //Instanciamos el Controlador.
    $objController = new animalController();
    //Obtener valores del formulario con POST.
    $id = $_POST['txtId'];
    $nombre = $_POST['txtNombre'];
    $sexo = $_POST['txtSexo'];
    $raza = $_POST['txtRaza'];
    $edad = $_POST['txtEdad'];
    $peso = $_POST['txtPeso'];
    $vacunas = $_POST['txtVacunas'];
    $dueno = $_POST['txtDueno'];
    $fechaNacimiento = $_POST['txtFechaNacimiento'];

    $objController->updateAnimal($id, $nombre, $sexo, $raza, $edad, $peso, $vacunas,
    $dueno, $fechaNacimiento);

?>
