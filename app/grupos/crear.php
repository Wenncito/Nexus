<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$error = '';
$success = '';

// Obtener lista de docentes para el select
$docentesStmt = $pdo->query("SELECT id, nombre, apellido_paterno, apellido_materno FROM docentes WHERE estado = 'Activo' ORDER BY nombre");
$docentes = $docentesStmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_grupo = trim($_POST['nombre_grupo']);
    $grado = trim($_POST['grado']);
    $semestre = trim($_POST['semestre']);
    $turno = trim($_POST['turno']);
    $docente_responsable_id = empty($_POST['docente_responsable_id']) ? NULL : $_POST['docente_responsable_id'];
    $estado = trim($_POST['estado']);

    if(empty($nombre_grupo) || empty($grado) || empty($semestre) || empty($turno)) {
        $error = "Campos obligatorios incompletos.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO grupos (nombre_grupo, grado, semestre, turno, docente_responsable_id, estado) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nombre_grupo, $grado, $semestre, $turno, $docente_responsable_id, $estado]);
            $success = "Grupo registrado correctamente.";
        } catch(PDOException $e) {
            $error = "Error al guardar el grupo: " . $e->getMessage();
        }
    }
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Registrar Grupo</h2>
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
                        <input type="text" name="nombre_grupo" class="form-control" placeholder="Ej. 1A" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Grado *</label>
                        <input type="number" name="grado" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Semestre *</label>
                        <input type="text" name="semestre" class="form-control" placeholder="Ej. Primero" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Turno *</label>
                        <select name="turno" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="Matutino">Matutino</option>
                            <option value="Vespertino">Vespertino</option>
                            <option value="Nocturno">Nocturno</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Docente Responsable</label>
                        <select name="docente_responsable_id" class="form-select">
                            <option value="">Ninguno</option>
                            <?php foreach($docentes as $doc): ?>
                                <option value="<?php echo $doc->id; ?>"><?php echo htmlspecialchars($doc->nombre . ' ' . $doc->apellido_paterno); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estado *</label>
                        <select name="estado" class="form-select" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Grupo</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
