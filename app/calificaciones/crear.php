<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$error = '';
$success = '';

$alumnos = $pdo->query("SELECT id, matricula, nombre, apellido_paterno FROM alumnos WHERE estado = 'Activo' ORDER BY apellido_paterno")->fetchAll();
$materias = $pdo->query("SELECT id, clave, nombre_materia FROM materias WHERE estado = 'Activo' ORDER BY nombre_materia")->fetchAll();
$docentes = $pdo->query("SELECT id, nombre, apellido_paterno FROM docentes WHERE estado = 'Activo' ORDER BY nombre")->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alumno_id = $_POST['alumno_id'];
    $materia_id = $_POST['materia_id'];
    $docente_id = $_POST['docente_id'];
    $parcial_1 = floatval($_POST['parcial_1'] ?? 0);
    $parcial_2 = floatval($_POST['parcial_2'] ?? 0);
    $parcial_3 = floatval($_POST['parcial_3'] ?? 0);
    $observaciones = trim($_POST['observaciones']);
    
    // Calcular promedio
    $promedio = ($parcial_1 + $parcial_2 + $parcial_3) / 3;

    if(empty($alumno_id) || empty($materia_id) || empty($docente_id)) {
        $error = "Debe seleccionar alumno, materia y docente.";
    } else {
        try {
            // Verificar si ya tiene calificaciones (opcional: podríamos hacer un update si existe, pero para mantenerlo simple hacemos insert o error)
            $check = $pdo->prepare("SELECT id FROM calificaciones WHERE alumno_id = ? AND materia_id = ?");
            $check->execute([$alumno_id, $materia_id]);
            if($check->fetch()) {
                $error = "El alumno ya tiene calificaciones registradas para esta materia.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO calificaciones (alumno_id, materia_id, docente_id, parcial_1, parcial_2, parcial_3, promedio, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$alumno_id, $materia_id, $docente_id, $parcial_1, $parcial_2, $parcial_3, $promedio, $observaciones]);
                $success = "Calificaciones registradas correctamente.";
            }
        } catch(PDOException $e) {
            $error = "Error al guardar: " . $e->getMessage();
        }
    }
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Registrar Calificación</h2>
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
                        <label class="form-label">Alumno *</label>
                        <select name="alumno_id" class="form-select" required>
                            <option value="">Seleccione un alumno...</option>
                            <?php foreach($alumnos as $al): ?>
                                <option value="<?php echo $al->id; ?>"><?php echo htmlspecialchars($al->matricula . ' - ' . $al->apellido_paterno . ' ' . $al->nombre); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Materia *</label>
                        <select name="materia_id" class="form-select" required>
                            <option value="">Seleccione una materia...</option>
                            <?php foreach($materias as $mat): ?>
                                <option value="<?php echo $mat->id; ?>"><?php echo htmlspecialchars($mat->clave . ' - ' . $mat->nombre_materia); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Docente *</label>
                        <select name="docente_id" class="form-select" required>
                            <option value="">Seleccione un docente...</option>
                            <?php foreach($docentes as $doc): ?>
                                <option value="<?php echo $doc->id; ?>"><?php echo htmlspecialchars($doc->nombre . ' ' . $doc->apellido_paterno); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Parcial 1</label>
                        <input type="number" step="0.01" min="0" max="10" name="parcial_1" class="form-control" value="0.00">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Parcial 2</label>
                        <input type="number" step="0.01" min="0" max="10" name="parcial_2" class="form-control" value="0.00">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Parcial 3</label>
                        <input type="number" step="0.01" min="0" max="10" name="parcial_3" class="form-control" value="0.00">
                    </div>
                    
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Calificaciones</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
