<?php
    require_once("../admin/template/header.php");
    require_once("../../controllers/animalController.php");
    //Instanciamos controlador para ejecutar la consulta.
    $objAnimalController = new animalController();
    //Capturar el id y saca la información del animal.
    $lstAnimal = $objAnimalController->readOneAnimal($_GET["id"]);
?>

<div class="card shadow">
    <div class="card-header card-header-ganadero">
        <i class="bi bi-eye"></i> INFORMACIÓN DEL ANIMAL (ID: <?= $lstAnimal['id'] ?>)
    </div>
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">NOMBRE DEL ANIMAL</label>
                    <input type="text" class="form-control" value="<?= $lstAnimal['nombre'] ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">SEXO</label>
                    <input type="text" class="form-control" value="<?= $lstAnimal['sexo'] ?>" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">RAZA</label>
                    <input type="text" class="form-control" value="<?= $lstAnimal['raza'] ?>" readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">EDAD (años)</label>
                    <input type="text" class="form-control" value="<?= $lstAnimal['edad'] ?>" readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">PESO (kg)</label>
                    <input type="text" class="form-control" value="<?= $lstAnimal['peso'] ?>" readonly>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">VACUNAS</label>
                <textarea class="form-control" rows="2" readonly><?= $lstAnimal['vacunas'] ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">DUEÑO</label>
                <input type="text" class="form-control" value="<?= $lstAnimal['dueno'] ?>" readonly>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">FECHA DE REGISTRO</label>
                    <input type="text" class="form-control" value="<?= $lstAnimal['fechaRegistro'] ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">FECHA DE NACIMIENTO</label>
                    <input type="text" class="form-control" value="<?= $lstAnimal['fechaNacimiento'] ?>" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">USUARIO</label>
                    <input type="text" class="form-control" value="<?= $lstAnimal['usuario'] ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">CONTRASEÑA</label>
                    <input type="text" class="form-control" value="<?= $lstAnimal['contrasena'] ?>" readonly>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer text-muted">
        DETALLE DEL ANIMAL.
    </div>
</div>
<div class="mt-3">
    <a href="readAllAnimales.php" class="btn btn-ganadero">
        <i class="bi bi-arrow-left"></i> Regresar
    </a>
</div>

<?php
    require_once("../admin/template/footer.php");
?>
