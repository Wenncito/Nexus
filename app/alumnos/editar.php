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

// Obtener datos actuales
$stmt = $pdo->prepare("SELECT * FROM alumnos WHERE id = ?");
$stmt->execute([$id]);
$alumno = $stmt->fetch();

if (!$alumno) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = trim($_POST['matricula']);
    $nombre = trim($_POST['nombre']);
    $apellido_paterno = trim($_POST['apellido_paterno']);
    $apellido_materno = trim($_POST['apellido_materno']);
    $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
    $sexo = trim($_POST['sexo']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $grupo_asignado = trim($_POST['grupo_asignado']);
    $estado = trim($_POST['estado']);

    try {
        $stmt = $pdo->prepare("UPDATE alumnos SET matricula=?, nombre=?, apellido_paterno=?, apellido_materno=?, fecha_nacimiento=?, sexo=?, correo=?, telefono=?, grupo_asignado=?, estado=? WHERE id=?");
        $stmt->execute([$matricula, $nombre, $apellido_paterno, $apellido_materno, $fecha_nacimiento, $sexo, $correo, $telefono, $grupo_asignado, $estado, $id]);
        $success = "Datos actualizados correctamente.";
        
        // Recargar datos
        $stmt = $pdo->prepare("SELECT * FROM alumnos WHERE id = ?");
        $stmt->execute([$id]);
        $alumno = $stmt->fetch();
    } catch(PDOException $e) {
        $error = "Error al actualizar: " . $e->getMessage();
    }
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Alumno</h2>
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
                        <label class="form-label">Matrícula *</label>
                        <input type="text" name="matricula" class="form-control" value="<?php echo htmlspecialchars($alumno->matricula); ?>" required>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nombre(s) *</label>
                        <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($alumno->nombre); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Apellido Paterno *</label>
                        <input type="text" name="apellido_paterno" class="form-control" value="<?php echo htmlspecialchars($alumno->apellido_paterno); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Apellido Materno</label>
                        <input type="text" name="apellido_materno" class="form-control" value="<?php echo htmlspecialchars($alumno->apellido_materno); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha de Nacimiento *</label>
                        <input type="date" name="fecha_nacimiento" class="form-control" value="<?php echo htmlspecialchars($alumno->fecha_nacimiento); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sexo *</label>
                        <select name="sexo" class="form-select" required>
                            <option value="Masculino" <?php echo ($alumno->sexo == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="Femenino" <?php echo ($alumno->sexo == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                            <option value="Otro" <?php echo ($alumno->sexo == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($alumno->telefono); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" value="<?php echo htmlspecialchars($alumno->correo); ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Grupo Asignado</label>
                        <input type="text" name="grupo_asignado" class="form-control" value="<?php echo htmlspecialchars($alumno->grupo_asignado); ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Estado *</label>
                        <select name="estado" class="form-select" required>
                            <option value="Activo" <?php echo ($alumno->estado == 'Activo') ? 'selected' : ''; ?>>Activo</option>
                            <option value="Inactivo" <?php echo ($alumno->estado == 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Actualizar Alumno</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
