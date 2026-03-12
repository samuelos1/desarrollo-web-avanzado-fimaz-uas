<?php
require_once "Usuario.php";

$usuario = new Usuario("Samuel Osuna Tirado", "samuelosuna393@gmail.com");

echo "Nombre: " . $usuario->getNombre() . "<br>";
echo "Correo: " . $usuario->getCorreo();
?>