<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "Admin.php";
require_once "Alumno.php";

$usuarios = [];
$errores = [];

try {
    $usuarios[] = new Admin("Samuel Osuna Tirado", "samuelosuna393@gmail.com");
} catch (Exception $e) {
    $errores[] = $e->getMessage();
}

try {
    $usuarios[] = new Alumno("Jose Fernando Lugo", "jflugo@gmail.com", "2319999");
} catch (Exception $e) {
    $errores[] = $e->getMessage();
}

try {
    $usuarios[] = new Alumno("Jesus Francisco", "jfco.com", "A54321");
} catch (Exception $e) {
    $errores[] = $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Usuarios</title>
</head>
<body>

<h2>Lista de Usuarios</h2>
<table border="1">
<tr>
<th>Nombre</th>
<th>Correo</th>
<th>Rol</th>
<th>Matrícula</th>
</tr>

<?php foreach ($usuarios as $u): ?>
<tr>
<td><?php echo $u->getNombre(); ?></td>
<td><?php echo $u->getCorreo(); ?></td>
<td><?php echo $u->getRol(); ?></td>
<td><?php echo ($u instanceof Alumno) ? $u->getMatricula() : "-"; ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php
if (!empty($errores)) {
    foreach ($errores as $e) {
        echo "<p style='color:red;'>Error: $e</p>";
    }
}
?>

</body>
</html>