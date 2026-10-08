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

$stmt = $pdo->prepare("SELECT * FROM materias WHERE id = ?");
$stmt->execute([$id]);
$materia = $stmt->fetch();

if (!$materia) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $clave = trim($_POST['clave']);
    $nombre_materia = trim($_POST['nombre_materia']);
    $descripcion = trim($_POST['descripcion']);
    $creditos = trim($_POST['creditos']);
    $estado = trim($_POST['estado']);

    try {
        $stmt = $pdo->prepare("UPDATE materias SET clave=?, nombre_materia=?, descripcion=?, creditos=?, estado=? WHERE id=?");
        $stmt->execute([$clave, $nombre_materia, $descripcion, $creditos, $estado, $id]);
        $success = "Datos actualizados correctamente.";
        
        $stmt = $pdo->prepare("SELECT * FROM materias WHERE id = ?");
        $stmt->execute([$id]);
        $materia = $stmt->fetch();
    } catch(PDOException $e) {
        $error = "Error al actualizar: " . $e->getMessage();
    }
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Materia</h2>
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
                        <input type="text" name="clave" class="form-control" value="<?php echo htmlspecialchars($materia->clave); ?>" required>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nombre de Materia *</label>
                        <input type="text" name="nombre_materia" class="form-control" value="<?php echo htmlspecialchars($materia->nombre_materia); ?>" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"><?php echo htmlspecialchars($materia->descripcion); ?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Créditos *</label>
                        <input type="number" name="creditos" class="form-control" value="<?php echo htmlspecialchars($materia->creditos); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado *</label>
                        <select name="estado" class="form-select" required>
                            <option value="Activo" <?php echo ($materia->estado == 'Activo') ? 'selected' : ''; ?>>Activo</option>
                            <option value="Inactivo" <?php echo ($materia->estado == 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Actualizar Materia</button>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
