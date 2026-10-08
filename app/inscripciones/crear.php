<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$error = '';
$success = '';

// Obtener listas
$alumnos = $pdo->query("SELECT id, matricula, nombre, apellido_paterno FROM alumnos WHERE estado = 'Activo' ORDER BY apellido_paterno")->fetchAll();
$grupos = $pdo->query("SELECT id, nombre_grupo, grado, turno FROM grupos WHERE estado = 'Activo' ORDER BY nombre_grupo")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumno_id = $_POST['alumno_id'];
    $grupo_id = $_POST['grupo_id'];
    $fecha_inscripcion = date('Y-m-d');
    $estado = 'Activo';

    if(empty($alumno_id) || empty($grupo_id)) {
        $error = "Debe seleccionar un alumno y un grupo.";
    } else {
        try {
            // Verificar si ya está inscrito
            $check = $pdo->prepare("SELECT id FROM inscripciones WHERE alumno_id = ? AND grupo_id = ?");
            $check->execute([$alumno_id, $grupo_id]);
            if($check->fetch()) {
                $error = "El alumno ya está inscrito en este grupo.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO inscripciones (alumno_id, grupo_id, fecha_inscripcion, estado) VALUES (?, ?, ?, ?)");
                $stmt->execute([$alumno_id, $grupo_id, $fecha_inscripcion, $estado]);
                
                // Actualizar grupo en tabla alumnos
                $grupoInfo = $pdo->prepare("SELECT nombre_grupo FROM grupos WHERE id = ?");
                $grupoInfo->execute([$grupo_id]);
                $ng = $grupoInfo->fetchColumn();
                
                $update = $pdo->prepare("UPDATE alumnos SET grupo_asignado = ? WHERE id = ?");
                $update->execute([$ng, $alumno_id]);
                
                $success = "Inscripción registrada correctamente.";
            }
        } catch(PDOException $e) {
            $error = "Error al guardar: " . $e->getMessage();
        }
    }
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Registrar Inscripción</h2>
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
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Alumno *</label>
                        <select name="alumno_id" class="form-select" required>
                            <option value="">Seleccione un alumno...</option>
                            <?php foreach($alumnos as $al): ?>
                                <option value="<?php echo $al->id; ?>"><?php echo htmlspecialchars($al->matricula . ' - ' . $al->apellido_paterno . ' ' . $al->nombre); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Grupo *</label>
                        <select name="grupo_id" class="form-select" required>
                            <option value="">Seleccione un grupo...</option>
                            <?php foreach($grupos as $gr): ?>
                                <option value="<?php echo $gr->id; ?>"><?php echo htmlspecialchars($gr->nombre_grupo . ' (' . $gr->turno . ')'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Inscribir Alumno</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
