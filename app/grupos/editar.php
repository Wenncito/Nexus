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

$stmt = $pdo->prepare("SELECT * FROM grupos WHERE id = ?");
$stmt->execute([$id]);
$grupo = $stmt->fetch();

if (!$grupo) {
    header("Location: index.php");
    exit();
}

// Obtener lista de docentes
$docentesStmt = $pdo->query("SELECT id, nombre, apellido_paterno, apellido_materno FROM docentes WHERE estado = 'Activo' ORDER BY nombre");
$docentes = $docentesStmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_grupo = trim($_POST['nombre_grupo']);
    $grado = trim($_POST['grado']);
    $semestre = trim($_POST['semestre']);
    $turno = trim($_POST['turno']);
    $docente_responsable_id = empty($_POST['docente_responsable_id']) ? NULL : $_POST['docente_responsable_id'];
    $estado = trim($_POST['estado']);

    try {
        $stmt = $pdo->prepare("UPDATE grupos SET nombre_grupo=?, grado=?, semestre=?, turno=?, docente_responsable_id=?, estado=? WHERE id=?");
        $stmt->execute([$nombre_grupo, $grado, $semestre, $turno, $docente_responsable_id, $estado, $id]);
        $success = "Datos actualizados correctamente.";
        
        $stmt = $pdo->prepare("SELECT * FROM grupos WHERE id = ?");
        $stmt->execute([$id]);
        $grupo = $stmt->fetch();
    } catch(PDOException $e) {
        $error = "Error al actualizar: " . $e->getMessage();
    }
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Grupo</h2>
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
                        <label class="form-label">Nombre del Grupo *</label>
                        <input type="text" name="nombre_grupo" class="form-control" value="<?php echo htmlspecialchars($grupo->nombre_grupo); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Grado *</label>
                        <input type="number" name="grado" class="form-control" value="<?php echo htmlspecialchars($grupo->grado); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Semestre *</label>
                        <input type="text" name="semestre" class="form-control" value="<?php echo htmlspecialchars($grupo->semestre); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Turno *</label>
                        <select name="turno" class="form-select" required>
                            <option value="Matutino" <?php echo ($grupo->turno == 'Matutino') ? 'selected' : ''; ?>>Matutino</option>
                            <option value="Vespertino" <?php echo ($grupo->turno == 'Vespertino') ? 'selected' : ''; ?>>Vespertino</option>
                            <option value="Nocturno" <?php echo ($grupo->turno == 'Nocturno') ? 'selected' : ''; ?>>Nocturno</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Docente Responsable</label>
                        <select name="docente_responsable_id" class="form-select">
                            <option value="">Ninguno</option>
                            <?php foreach($docentes as $doc): ?>
                                <option value="<?php echo $doc->id; ?>" <?php echo ($grupo->docente_responsable_id == $doc->id) ? 'selected' : ''; ?>><?php echo htmlspecialchars($doc->nombre . ' ' . $doc->apellido_paterno); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estado *</label>
                        <select name="estado" class="form-select" required>
                            <option value="Activo" <?php echo ($grupo->estado == 'Activo') ? 'selected' : ''; ?>>Activo</option>
                            <option value="Inactivo" <?php echo ($grupo->estado == 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Actualizar Grupo</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
