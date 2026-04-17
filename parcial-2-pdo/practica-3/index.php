<?php
$host    = "localhost";
$db      = "escuela1";
$user    = "root";
$pass    = "";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

$mensaje = "";
$detalle = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre      = trim($_POST["nombre"] ?? "");
    $apellido    = trim($_POST["apellido"] ?? "");
    $correo      = trim($_POST["correo"] ?? "");
    $simularError = isset($_POST["simular_error"]);

    if ($nombre === "" || $apellido === "" || $correo === "") {
        $mensaje = "⚠️ Todos los campos son obligatorios.";
    } else {
        try {            
            $pdo->beginTransaction();

            $sqlAlumno = "INSERT INTO alumnos (nombre, apellido, correo) VALUES (:nombre, :apellido, :correo)";
            $stmtAlumno = $pdo->prepare($sqlAlumno);
            $stmtAlumno->execute([
                "nombre"   => $nombre,
                "apellido" => $apellido,
                "correo"   => $correo
            ]);

            $idAlumnos = (int)$pdo->lastInsertId();

            if ($simularError) {
                throw new Exception("Simulación de error activada: se fuerza rollback.");
            } else {
                
                $sqlLog = "INSERT INTO log_alumnos (idAlumno, accion) VALUES (:idAlumno, :accion)";
                $stmtLog = $pdo->prepare($sqlLog);
                $stmtLog->execute([
                    "idAlumno" => $idAlumnos,
                    "accion"   => "ALTA_ALUMNO"
                ]);
            }

            $pdo->commit();
            $mensaje = "✅ Transacción confirmada (COMMIT). Alumno registrado con ID: $idAlumnos";

        } catch (Exception $e){
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $mensaje = "❌ Ocurrido un error. Transacción revertida (ROLLBACK).";
            $detalle = $e->getMessage();
        }
    }
}

$alumnos = $pdo->query("SELECT * FROM alumnos ORDER BY idAlumnos DESC")->fetchAll();
$logs    = $pdo->query("SELECT * FROM log_alumnos ORDER BY idLog DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica PDO: Transacciones</title>
    <style>
        body{ font-family: Arial, sans-serif; margin:20px; line-height:1.4; background-color: #f9f9f9; }
        .card{ border:1px solid #ddd; border-radius:10px; padding:16px; margin-bottom:16px; background: white; shadow: 2px 2px 5px #eee; }
        .row{ display:flex; gap:12px; flex-wrap:wrap; }
        label{ display:block; font-weight:bold; margin-bottom:6px; }
        input[type="text"], input[type="email"]{ width:200px; padding:8px; border:1px solid #ccc; border-radius:6px; }
        button{ padding:10px 14px; background:#0b5ed7; color:white; border:0; border-radius:6px; cursor:pointer; }
        button:hover{ background:#0a58ca; }
        .msg{ padding:15px; border-radius:8px; background:#fff; border-left: 5px solid #0b5ed7; margin-bottom: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .danger{ color:#b02a37; font-weight: bold; }
        table{ border-collapse:collapse; width:100%; margin-top:10px; }
        th, td{ border:1px solid #ddd; padding:10px; text-align:left; }
        th{ background:#f0f0f0; }
        tr:nth-child(even){ background-color: #fcfcfc; }
    </style>
</head>
<body>

    <h2>Práctica: try/catch y transacciones (PDO + MySQL)</h2>

    <div class="card">
        <form method="POST">
            <div class="row">
                <div>
                    <label>Nombre</label>
                    <input type="text" name="nombre" value="Samuel" required>
                </div>
                <div>
                    <label>Apellido</label>
                    <input type="text" name="apellido" value="Osuna" required>
                </div>
                <div>
                    <label>Correo</label>
                    <input type="email" name="correo" value="samuelosuna393@gmail.com" required>
                </div>
            </div>
            <p>
                <label style="font-weight:normal; cursor:pointer;">
                    <input type="checkbox" name="simular_error"> <strong>Simular error</strong> para forzar ROLLBACK
                </label>
            </p>
            <button type="submit">Registrar alumno</button>
        </form>
     </div>

    <?php if ($mensaje): ?>
        <div class="msg">
            <p><?php echo htmlspecialchars($mensaje); ?></p>
            <?php if ($detalle): ?>
                <p class="danger"><small>Detalle del error: <?php echo htmlspecialchars($detalle); ?></small></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <h3>Tabla alumnos</h3>
        <table>
            <thead><tr><th>ID (idAlumnos)</th><th>Nombre</th><th>Apellido</th><th>Correo</th></tr></thead>
            <tbody>
                <?php foreach ($alumnos as $a): ?>
                    <tr>
                        <td><?= $a['idAlumnos'] ?></td> 
                        <td><?= htmlspecialchars($a['nombre']) ?></td>
                        <td><?= htmlspecialchars($a['apellido']) ?></td>
                        <td><?= htmlspecialchars($a['correo']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3>Tabla log_alumnos</h3>
        <table>
            <thead><tr><th>ID Log</th><th>ID Alumno</th><th>Acción</th><th>Fecha</th></tr></thead>
            <tbody>
                <?php foreach ($logs as $l): ?>
                    <tr>
                        <td><?= $l['idLog'] ?></td>
                        <td><?= $l['idAlumno'] ?></td>
                        <td><?= htmlspecialchars($l['accion']) ?></td>
                        <td><?= $l['fecha'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
