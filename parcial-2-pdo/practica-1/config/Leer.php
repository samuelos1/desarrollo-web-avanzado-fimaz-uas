<?php
include "db.php";

    $sql = "SELECT * FROM alumnos";
    $stmt = $pdo->query($sql);

    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3> Listado de alumnos</h3>";
    foreach ($alumnos as $alumno) {
        echo $alumno['idAlumno'] ." _ "
        . $alumno['nombre'] . " "
        . $alumno['apellido'] . " | "
        . $alumno['correo'] . "<br>";
    }
?>