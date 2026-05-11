<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SystemControl By SAMUEL - Sistema de Control Ganadero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f1f8f1; }
        .navbar-ganadero { background-color: #2d6a2d; }
        .navbar-ganadero .navbar-brand, .navbar-ganadero .nav-link { color: #fff !important; }
        .card-header-ganadero { background-color: #3a7d3a; color: #fff; font-weight: bold; }
        .btn-ganadero { background-color: #3a7d3a; color: #fff; border: none; }
        .btn-ganadero:hover { background-color: #2d6a2d; color: #fff; }
        .table thead { background-color: #3a7d3a; color: #fff; }
        h1.titulo { color: #2d6a2d; font-weight: bold; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-ganadero mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="admin.php">
                <img src="/GanadoControl/views/admin/img/logo.jpg" alt="GanadoControl Logo" height="45"
                style="object-fit:contain;">
                SystemControl By SAMUEL
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php"><i class="bi bi-house"></i> Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="frmAnimal.php"><i class="bi bi-plus-circle"></i> Registrar Animal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="readAllAnimales.php"><i class="bi bi-list-ul"></i> Ver Animales</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">




