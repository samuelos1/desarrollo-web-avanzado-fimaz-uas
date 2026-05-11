<?php
    require_once("../admin/template/header.php");
?>

<div class="card shadow">
    <div class="card-header card-header-ganadero">
        <i class="bi bi-plus-circle"></i> REGISTRAR ANIMAL
    </div>
    <div class="card-body">
        <form action="animalInsert.php" method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">NOMBRE DEL ANIMAL</label>
                    <input type="text" class="form-control" name="txtNombre" id="nombre" placeholder="Ej: Estrella">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="sexo" class="form-label">SEXO</label>
                    <select name="txtSexo" id="sexo" class="form-select">
                        <option value="">-- Selecciona --</option>
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="raza" class="form-label">RAZA</label>
                    <input type="text" class="form-control" name="txtRaza" id="raza" placeholder="Ej: Angus, Hereford">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="edad" class="form-label">EDAD (años)</label>
                    <input type="number" class="form-control" name="txtEdad" id="edad" min="0" step="0.1">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="peso" class="form-label">PESO (kg)</label>
                    <input type="number" class="form-control" name="txtPeso" id="peso" min="0" step="0.1">
                </div>
            </div>
            <div class="mb-3">
                <label for="vacunas" class="form-label">VACUNAS</label>
                <textarea name="txtVacunas" id="vacunas" cols="30" rows="2"
                class="form-control" placeholder="Ej: Fiebre aftosa, Brucelosis..."></textarea>
                <span class="form-text text-muted">Puede separar con "," si hay más de una vacuna.</span>
            </div>
            <div class="mb-3">
                <label for="dueno" class="form-label">DUEÑO</label>
                <input type="text" class="form-control" name="txtDueno" id="dueno" placeholder="Nombre completo del dueño">
            </div>
            <div class="mb-3">
                <label for="fechaNacimiento" class="form-label">FECHA DE NACIMIENTO</label>
                <input type="date" class="form-control" name="txtFechaNacimiento" id="fechaNacimiento">
            </div>
            <!-- Usuario y Contraseña -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="usuario" class="form-label">USUARIO</label>
                    <input type="text" class="form-control" name="txtUsuario" id="usuario">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contrasena" class="form-label">CONTRASEÑA</label>
                    <input type="password" class="form-control" name="txtContrasena" id="contrasena">
                </div>
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
        FORMULARIO PARA REGISTRAR ANIMALES.
    </div>
</div>

<?php
    require_once("../admin/template/footer.php");
?>
