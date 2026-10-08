<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM materias ORDER BY id DESC");
$materias = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Materias</h2>
        <a href="crear.php" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva Materia</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Clave</th>
                            <th>Nombre de Materia</th>
                            <th>Créditos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($materias as $materia): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($materia->clave); ?></td>
                            <td><?php echo htmlspecialchars($materia->nombre_materia); ?></td>
                            <td><?php echo htmlspecialchars($materia->creditos); ?></td>
                            <td>
                                <?php if($materia->estado == 'Activo'): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="editar.php?id=<?php echo $materia->id; ?>" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                <a href="eliminar.php?id=<?php echo $materia->id; ?>" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
