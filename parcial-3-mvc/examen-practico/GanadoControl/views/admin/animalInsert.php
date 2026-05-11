<?php
    require_once("../../controllers/animalController.php");
    //Guarda los valores introducidos por el usuario.
    $nombre = $_POST['txtNombre'];
    $sexo = $_POST['txtSexo'];
    $raza = $_POST['txtRaza'];
    $edad = $_POST['txtEdad'];
    $peso = $_POST['txtPeso'];
    $vacunas = $_POST['txtVacunas'];
    $dueno = $_POST['txtDueno'];
    $fechaNacimiento = $_POST['txtFechaNacimiento'];
    $usuario = $_POST['txtUsuario'];
    $contrasena = $_POST['txtContrasena'];

    //Instanciamos el Controlador.
    $objController = new animalController();
    $objController->saveAnimal($nombre, $sexo, $raza, $edad, $peso, $vacunas, $dueno,
    $fechaNacimiento, $usuario, $contrasena);

?>
