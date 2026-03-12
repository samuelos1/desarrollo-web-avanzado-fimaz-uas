<?php
require_once "Admin.php";
require_once "Alumno.php";

try {
    
    $admin = new Admin("Samuel Osuna Tirado", "samuelosuna393@gmail.com");
    $alumno = new Alumno("Jose Francisco Tirado", "frantirado@gmail.com", "A123");

    echo "Administrador:<br>";
    echo "Nombre: " . $admin->getNombre() . "<br>";
    echo "Correo: " . $admin->getCorreo() . "<br>";
    echo "Rol: " . $admin->getRol() . "<br><br>";

    echo "Alumno:<br>";
    echo "Nombre: " . $alumno->getNombre() . "<br>";
    echo "Correo: " . $alumno->getCorreo() . "<br>";
    echo "Rol: " . $alumno->getRol() . "<br>";
    echo "Matrícula: " . $alumno->getMatricula() . "<br><br>";

    
    $usuarioInvalido = new Alumno("Jesus Yibran", "yibran2004mail.com", "9999"); // correo inválido

} catch (Exception $e) {
    
    echo "Error: " . $e->getMessage();
}
?>