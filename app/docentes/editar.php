<?php
require_once '../config/database.php';
require_once '../includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$error = '';
$success = '';

$stmt = $pdo->prepare("SELECT * FROM docentes WHERE id = ?");
$stmt->execute([$id]);
$docente = $stmt->fetch();

if (!$docente) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_empleado = trim($_POST['numero_empleado']);
    $nombre = trim($_POST['nombre']);
    $apellido_paterno = trim($_POST['apellido_paterno']);
    $apellido_materno = trim($_POST['apellido_materno']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $especialidad = trim($_POST['especialidad']);
    $estado = trim($_POST['estado']);

    try {
        $stmt = $pdo->prepare("UPDATE docentes SET numero_empleado=?, nombre=?, apellido_paterno=?, apellido_materno=?, correo=?, telefono=?, especialidad=?, estado=? WHERE id=?");
        $stmt->execute([$numero_empleado, $nombre, $apellido_paterno, $apellido_materno, $correo, $telefono, $especialidad, $estado, $id]);
        $success = "Datos actualizados correctamente.";
        
        $stmt = $pdo->prepare("SELECT * FROM docentes WHERE id = ?");
        $stmt->execute([$id]);
        $docente = $stmt->fetch();
    } catch(PDOException $e) {
        $error = "Error al actualizar: " . $e->getMessage();
    }
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Docente</h2>
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
                        <input type="text" name="numero_empleado" class="form-control" value="<?php echo htmlspecialchars($docente->numero_empleado); ?>" required>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nombre(s) *</label>
                        <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($docente->nombre); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Apellido Paterno *</label>
                        <input type="text" name="apellido_paterno" class="form-control" value="<?php echo htmlspecialchars($docente->apellido_paterno); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Apellido Materno</label>
                        <input type="text" name="apellido_materno" class="form-control" value="<?php echo htmlspecialchars($docente->apellido_materno); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" value="<?php echo htmlspecialchars($docente->correo); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($docente->telefono); ?>">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Especialidad *</label>
                        <input type="text" name="especialidad" class="form-control" value="<?php echo htmlspecialchars($docente->especialidad); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estado *</label>
                        <select name="estado" class="form-select" required>
                            <option value="Activo" <?php echo ($docente->estado == 'Activo') ? 'selected' : ''; ?>>Activo</option>
                            <option value="Inactivo" <?php echo ($docente->estado == 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Actualizar Docente</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
