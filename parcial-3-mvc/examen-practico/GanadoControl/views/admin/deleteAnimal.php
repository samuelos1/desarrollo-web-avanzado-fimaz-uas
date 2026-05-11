<?php

    require_once("../../controllers/animalController.php");
    $objAnimalController = new animalController();
    //Obtener el id desde el botón que mandará eliminar el registro.
    //Lo obtendremos de la pantalla del listado general de animales.
    $objAnimalController->delete($_GET['id']);

?>
