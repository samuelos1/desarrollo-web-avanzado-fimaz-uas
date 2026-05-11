<?php
    require_once("../admin/template/header.php");
?>

<h1 class="titulo mb-4"><i class="bi bi-cow"></i> Panel de Control Ganadero</h1>

<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card shadow h-100">
            <div class="card-header card-header-ganadero text-center">
                <i class="bi bi-plus-circle fs-3"></i>
                <div>REGISTRAR ANIMAL</div>
            </div>
            <div class="card-body text-center">
                <p class="card-text">Agrega un nuevo animal al sistema de control.</p>
                <a href="frmAnimal.php" class="btn btn-ganadero">
                    <i class="bi bi-plus-circle"></i> Registrar
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow h-100">
            <div class="card-header card-header-ganadero text-center">
                <i class="bi bi-list-ul fs-3"></i>
                <div>LISTA DE ANIMALES</div>
            </div>
            <div class="card-body text-center">
                <p class="card-text">Consulta todos los animales registrados en el sistema.</p>
                <a href="readAllAnimales.php" class="btn btn-ganadero">
                    <i class="bi bi-list-ul"></i> Ver Lista
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card shadow h-100">
            <div class="card-header card-header-ganadero text-center">
                <i class="bi bi-bar-chart fs-3"></i>
                <div>ESTADÍSTICAS</div>
            </div>
            <div class="card-body text-center">
                <p class="card-text">Resumen general del inventario ganadero.</p>
                <a href="#" class="btn btn-ganadero">
                    <i class="bi bi-bar-chart"></i> Ver Stats
                </a>
            </div>
        </div>
    </div>
</div>

<?php
    require_once("../admin/template/footer.php");
?>
