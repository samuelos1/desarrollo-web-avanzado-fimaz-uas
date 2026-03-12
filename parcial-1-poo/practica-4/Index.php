<?php


require_once "clases/Admin.php";
require_once "clases/Alumno.php";
require_once "clases/Invitado.php";
$usuarios = [];

try {

    $usuarios[] = new Admin("Samuel Osuna Tirado", "samuelosuna393@gmail.com");
    $usuarios[] = new Alumno("Bryant Zamudio", "bryantz@gmail.com", "01010");
    $usuarios[] = new Invitado("Luis Jesus Vazquez", "ljvg@gmail.com", "Empresa Fimaz");

    $usuarios[] = new Alumno("Michelle Quintero", "michell.com", "A002");

} catch (Exception $e) {
    echo "Error controlado: " . $e->getMessage();
}

echo "<h3>Usuarios registrados</h3>";

echo "<table border='1'>";
echo "<tr><th>Nombre</th><th>Correo</th><th>Rol</th></tr>";

foreach ($usuarios as $u) {
    echo "<tr>";
    echo "<td>" . $u->getNombre() . "</td>";
    echo "<td>" . $u->getCorreo() . "</td>";
    echo "<td>" . $u->getRol() . "</td>";
    echo "</tr>";
}

echo "</table>";

?>