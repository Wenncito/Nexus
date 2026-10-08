<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_empleado = trim($_POST['numero_empleado']);
    $nombre = trim($_POST['nombre']);
    $apellido_paterno = trim($_POST['apellido_paterno']);
    $apellido_materno = trim($_POST['apellido_materno']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $especialidad = trim($_POST['especialidad']);
    $estado = trim($_POST['estado']);

    if(empty($numero_empleado) || empty($nombre) || empty($apellido_paterno) || empty($especialidad)) {
        $error = "Campos obligatorios incompletos.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO docentes (numero_empleado, nombre, apellido_paterno, apellido_materno, correo, telefono, especialidad, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$numero_empleado, $nombre, $apellido_paterno, $apellido_materno, $correo, $telefono, $especialidad, $estado]);
            $success = "Docente registrado correctamente.";
        } catch(PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "Error: El número de empleado ya existe.";
            } else {
                $error = "Error al guardar el docente: " . $e->getMessage();
            }
        }
    }
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Registrar Docente</h2>
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
    </div>

    <?php if(!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if(!empty($success)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Número de Empleado *</label>
                        <input type="text" name="numero_empleado" class="form-control" required>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nombre(s) *</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Apellido Paterno *</label>
                        <input type="text" name="apellido_paterno" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Apellido Materno</label>
                        <input type="text" name="apellido_materno" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Especialidad *</label>
                        <input type="text" name="especialidad" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estado *</label>
                        <select name="estado" class="form-select" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Docente</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
