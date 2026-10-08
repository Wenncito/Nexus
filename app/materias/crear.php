<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clave = trim($_POST['clave']);
    $nombre_materia = trim($_POST['nombre_materia']);
    $descripcion = trim($_POST['descripcion']);
    $creditos = trim($_POST['creditos']);
    $estado = trim($_POST['estado']);

    if(empty($clave) || empty($nombre_materia) || empty($creditos)) {
        $error = "Campos obligatorios incompletos.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO materias (clave, nombre_materia, descripcion, creditos, estado) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$clave, $nombre_materia, $descripcion, $creditos, $estado]);
            $success = "Materia registrada correctamente.";
        } catch(PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "Error: La clave de la materia ya existe.";
            } else {
                $error = "Error al guardar la materia: " . $e->getMessage();
            }
        }
    }
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Registrar Materia</h2>
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
                        <label class="form-label">Clave *</label>
                        <input type="text" name="clave" class="form-control" required>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nombre de Materia *</label>
                        <input type="text" name="nombre_materia" class="form-control" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Créditos *</label>
                        <input type="number" name="creditos" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado *</label>
                        <select name="estado" class="form-select" required>
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Materia</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
