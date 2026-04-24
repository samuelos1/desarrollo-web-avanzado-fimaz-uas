<?php
// Samuel Osuna Tirado
require_once 'controllers/ProductoController.php';
$controller = new ProductoController();
$productoEditar = null;

if (isset($_GET['eliminar'])) {
    $controller->eliminar($_GET['eliminar']);
    header("Location: index.php");
}

if (isset($_GET['editar'])) {
    $productoEditar = $controller->obtenerPorId($_GET['editar']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p = new Producto($_POST['id'], $_POST['nombre'], $_POST['descripcion'], $_POST['existencia'], $_POST['precio']);
    if (!empty($_POST['id'])) {
        $controller->actualizar($p);
    } else {
        $controller->crear($p);
    }
    header("Location: index.php");
}

$productos = $controller->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Samuel Osuna Tirado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2 class="text-center">Manejo de Productos - Samuel Osuna Tirado</h2>

    <div class="card my-4">
        <div class="card-header"><?= $productoEditar ? 'Editar Producto' : 'Nuevo Producto' ?></div>
        <div class="card-body">
            <form method="POST" class="row g-3">
                <input type="hidden" name="id" value="<?= $productoEditar['id'] ?? '' ?>">
                <div class="col-md-4"><input type="text" name="nombre" class="form-control" placeholder="Nombre" value="<?= $productoEditar['nombre'] ?? '' ?>" required></div>
                <div class="col-md-4"><input type="text" name="descripcion" class="form-control" placeholder="Descripción" value="<?= $productoEditar['descripcion'] ?? '' ?>"></div>
                <div class="col-md-2"><input type="number" name="existencia" class="form-control" placeholder="Cant." value="<?= $productoEditar['existencia'] ?? '' ?>"></div>
                <div class="col-md-2"><input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio" value="<?= $productoEditar['precio'] ?? '' ?>"></div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary"><?= $productoEditar ? 'Actualizar' : 'Guardar' ?></button>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-striped border">
        <thead>
            <tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Acciones</th></tr>
        </thead>
        <tbody>
            <?php foreach($productos as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item['nombre'] ?></td>
                <td>$<?= number_format($item['precio'], 2) ?></td>
                <td>
                    <a href="?editar=<?= $item['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="?eliminar=<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>