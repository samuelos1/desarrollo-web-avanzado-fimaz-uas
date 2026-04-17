<?php
include "db.php";

    $idAlumno = 1;

    $sql = "SELECT * FROM alumnos WHERE idAlumno = :idAlumno";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['idAlumno' => $idAlumno]);

    $alumno = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($alumno) {
    echo "<h3> Listado de alumnos</h3>";
    echo $alumno['idAlumno'] ." _ "
        . $alumno['nombre'] . " "
        . $alumno['apellido'] . " | "
        . $alumno['correo'] . "<br>";
    } else {
        echo "Alumno no encontrado<br>";
    }
?>