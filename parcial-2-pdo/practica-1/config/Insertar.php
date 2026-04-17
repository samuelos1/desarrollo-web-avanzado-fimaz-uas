<?php
    include "db.php";

    $sql = "INSERT INTO alumnos (nombre, apellido, correo) VALUES (:nombre, :apellido, :correo)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'nombre' => 'Samuel',
        'apellido' => 'Osuna',
        'correo' => 'samuelosuna393@gmail.com'
    ]);

    echo "Alumno insertado correctamente<br>";
?>