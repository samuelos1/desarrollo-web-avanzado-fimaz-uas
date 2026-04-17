<?php
include "db.php";
$idAlumno = 1;

    $sql ="DELETE FROM alumnos WHERE idAlumno = :idAlumno";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['idAlumno' => $idAlumno]);

    echo "Alumno eliminado correctamente<br>";
?>