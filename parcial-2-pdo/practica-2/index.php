<?php
require_once '../practica-1/conexion.php';

$stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email) VALUES (?, ?)");
$stmt->execute(["Pedro", "pedro@email.com"]);

$consulta = $pdo->query("SELECT * FROM usuarios");
$usuarios = $consulta->fetchAll(PDO::FETCH_ASSOC);

foreach ($usuarios as $usuario) {
    echo $usuario['nombre'] . " - " . $usuario['email'] . "<br>";
}
