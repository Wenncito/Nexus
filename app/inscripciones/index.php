<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$query = "SELECT i.*, a.nombre as alumno_nombre, a.apellido_paterno, a.matricula, g.nombre_grupo 
          FROM inscripciones i 
          JOIN alumnos a ON i.alumno_id = a.id 
          JOIN grupos g ON i.grupo_id = g.id 
          ORDER BY i.fecha_inscripcion DESC";
$stmt = $pdo->query($query);
$inscripciones = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Inscripciones</h2>
        <a href="crear.php" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva Inscripción</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Matrícula</th>
                            <th>Alumno</th>
                            <th>Grupo</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($inscripciones as $ins): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ins->matricula); ?></td>
                            <td><?php echo htmlspecialchars($ins->alumno_nombre . ' ' . $ins->apellido_paterno); ?></td>
                            <td><strong><?php echo htmlspecialchars($ins->nombre_grupo); ?></strong></td>
                            <td><?php echo htmlspecialchars($ins->fecha_inscripcion); ?></td>
                            <td>
                                <?php if($ins->estado == 'Activo'): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactivo</span>
                                <?php endif; ?>
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
