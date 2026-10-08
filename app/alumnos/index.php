<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$stmt = $pdo->query("SELECT * FROM alumnos ORDER BY id DESC");
$alumnos = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Alumnos</h2>
        <a href="crear.php" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Alumno</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Matrícula</th>
                            <th>Nombre Completo</th>
                            <th>Grupo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($alumnos as $alumno): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($alumno->matricula); ?></td>
                            <td><?php echo htmlspecialchars($alumno->nombre . ' ' . $alumno->apellido_paterno . ' ' . $alumno->apellido_materno); ?></td>
                            <td><?php echo htmlspecialchars($alumno->grupo_asignado); ?></td>
                            <td>
                                <?php if($alumno->estado == 'Activo'): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="ver.php?id=<?php echo $alumno->id; ?>" class="btn btn-info btn-sm text-white" title="Ver"><i class="fas fa-eye"></i></a>
                                <a href="editar.php?id=<?php echo $alumno->id; ?>" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                <a href="eliminar.php?id=<?php echo $alumno->id; ?>" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash"></i></a>
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
