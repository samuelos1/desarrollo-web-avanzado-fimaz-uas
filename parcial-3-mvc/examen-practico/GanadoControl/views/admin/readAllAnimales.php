<?php
    require_once("../admin/template/header.php");
    require_once("../../controllers/animalController.php");
    //Instanciamos controlador para ejecutar la consulta.
    $objAnimalController = new animalController();
    //Capturamos los registros de la tabla en "filas".
    $rows = $objAnimalController->readAnimales();
?>

<div class="card shadow">
    <div class="card-header card-header-ganadero">
        <i class="bi bi-list-ul"></i> LISTADO DE ANIMALES
    </div>
    <div class="card-body">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">SEXO</th>
                    <th scope="col">RAZA</th>
                    <th scope="col">DUEÑO</th>
                    <th scope="col">F. REGISTRO</th>
                    <th scope="col">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php if($rows): ?>
                    <?php foreach($rows as $row): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['nombre'] ?></td>
                            <td><?= $row['sexo'] ?></td>
                            <td><?= $row['raza'] ?></td>
                            <td><?= $row['dueno'] ?></td>
                            <td><?= $row['fechaRegistro'] ?></td>
                            <td>
                                <a href="readOneAnimal.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="updateAnimal.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning text-white">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <!-- Modal eliminar -->
                                <button type="button" class="btn btn-sm btn-danger"
                                data-bs-toggle="modal" data-bs-target="#idModal<?= $row['id'] ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <div class="modal fade" id="idModal<?= $row['id'] ?>"
                                tabindex="-1" aria-labelledby="Modal<?= $row['id'] ?>"
                                aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#2d6a2d; color:#fff;">
                                                <h1 class="modal-title fs-5" id="Modal<?= $row['id'] ?>">
                                                    ¿Desea eliminar el animal?
                                                </h1>
                                                <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Esta acción no se puede deshacer......
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                                <a href="deleteAnimal.php?id=<?= $row['id'] ?>"
                                                class="btn btn-danger">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No hay animales registrados aún.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">
    <a href="admin.php" class="btn btn-ganadero">
        <i class="bi bi-arrow-left"></i> Regresar
    </a>
</div>

<?php
    require_once("../admin/template/footer.php");
?>
