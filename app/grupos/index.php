<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$query = "SELECT g.*, d.nombre, d.apellido_paterno 
          FROM grupos g 
          LEFT JOIN docentes d ON g.docente_responsable_id = d.id 
          ORDER BY g.id DESC";
$stmt = $pdo->query($query);
$grupos = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Grupos</h2>
        <a href="crear.php" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Grupo</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre del Grupo</th>
                            <th>Grado</th>
                            <th>Semestre</th>
                            <th>Turno</th>
                            <th>Docente Responsable</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($grupos as $grupo): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($grupo->nombre_grupo); ?></strong></td>
                            <td><?php echo htmlspecialchars($grupo->grado); ?></td>
                            <td><?php echo htmlspecialchars($grupo->semestre); ?></td>
                            <td><?php echo htmlspecialchars($grupo->turno); ?></td>
                            <td>
                                <?php 
                                if($grupo->docente_responsable_id) {
                                    echo htmlspecialchars($grupo->nombre . ' ' . $grupo->apellido_paterno);
                                } else {
                                    echo '<span class="text-muted">Sin asignar</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if($grupo->estado == 'Activo'): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="editar.php?id=<?php echo $grupo->id; ?>" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                <a href="eliminar.php?id=<?php echo $grupo->id; ?>" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash"></i></a>
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
