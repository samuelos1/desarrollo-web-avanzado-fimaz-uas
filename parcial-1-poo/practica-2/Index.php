<?php
require_once "Admin.php";

$admin = new Admin("Samuel Osuna Tirado", "samuelosuna393@.gmail.com");

echo "Nombre: " . $admin->getNombre() . "<br>";
echo "Correo: " . $admin->getCorreo() . "<br>";
echo "Rol: " . $admin->getRol();
?>