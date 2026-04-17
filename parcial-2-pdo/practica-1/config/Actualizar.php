<?php
include "db.php";
$idAlumno = 1;

    $sql ="UPDATE alumnos SET nombre = :nombre, apellido = :apellido, 
    correo = :correo WHERE idAlumno = :idAlumno";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'nombre' => 'Aydali Berenis',
        'apellido' => 'Nevarez',
        'correo' => 'ayda8782@gmail.com',
        'idAlumno' => $idAlumno
    ]);

    echo "Alumno actualizado correctamente<br>";
?>