<?php
    require_once("../admin/template/header.php");
    require_once("../../controllers/animalController.php");
    //Instanciamos el Controlador.
    $objAnimalController = new animalController();
    //Captura el id y nos da la información del animal.
    $lstAnimal = $objAnimalController->readOneAnimal($_GET['id']);
?>

<div class="card shadow">
    <div class="card-header card-header-ganadero">
        <i class="bi bi-pencil"></i> EDITAR ANIMAL (ID: <?= $lstAnimal['id'] ?>)
    </div>
    <div class="card-body">
        <form action="animalUpdate.php" method="post">
            <input type="hidden" name="txtId" value="<?= $lstAnimal['id'] ?>">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">NOMBRE DEL ANIMAL</label>
                    <input type="text" class="form-control" name="txtNombre"
                    value="<?= $lstAnimal['nombre'] ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">SEXO</label>
                    <select name="txtSexo" class="form-select">
                        <option value="Macho" <?= $lstAnimal['sexo'] == 'Macho' ? 'selected' : '' ?>>Macho</option>
                        <option value="Hembra" <?= $lstAnimal['sexo'] == 'Hembra' ? 'selected' : '' ?>>Hembra</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">RAZA</label>
                    <input type="text" class="form-control" name="txtRaza"
                    value="<?= $lstAnimal['raza'] ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">EDAD (años)</label>
                    <input type="number" class="form-control" name="txtEdad"
                    value="<?= $lstAnimal['edad'] ?>" min="0" step="0.1">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">PESO (kg)</label>
                    <input type="number" class="form-control" name="txtPeso"
                    value="<?= $lstAnimal['peso'] ?>" min="0" step="0.1">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">VACUNAS</label>
                <textarea class="form-control" name="txtVacunas" rows="2"><?= $lstAnimal['vacunas'] ?></textarea>
                <span class="form-text text-muted">Puede separar con "," si hay más de una vacuna.</span>
            </div>
            <div class="mb-3">
                <label class="form-label">DUEÑO</label>
                <input type="text" class="form-control" name="txtDueno"
                value="<?= $lstAnimal['dueno'] ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">FECHA DE NACIMIENTO</label>
                <input type="date" class="form-control" name="txtFechaNacimiento"
                value="<?= $lstAnimal['fechaNacimiento'] ?>">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-ganadero">
                    <i class="bi bi-save"></i> Guardar
                </button>
                <a href="admin.php" class="btn btn-danger">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
    <div class="card-footer text-muted">
        EDITAR INFORMACIÓN DEL ANIMAL.
    </div>
</div>

<?php
    require_once("../admin/template/footer.php");
?>
