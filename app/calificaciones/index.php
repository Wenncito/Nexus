<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$query = "SELECT c.*, a.nombre as alumno_nombre, a.apellido_paterno, m.nombre_materia, d.nombre as docente_nombre, d.apellido_paterno as docente_apellido 
          FROM calificaciones c 
          JOIN alumnos a ON c.alumno_id = a.id 
          JOIN materias m ON c.materia_id = m.id 
          JOIN docentes d ON c.docente_id = d.id 
          ORDER BY a.apellido_paterno, m.nombre_materia";
$stmt = $pdo->query($query);
$calificaciones = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Calificaciones</h2>
        <a href="crear.php" class="btn btn-primary"><i class="fas fa-plus"></i> Registrar Calificación</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Alumno</th>
                            <th>Materia</th>
                            <th>Docente</th>
                            <th>P1</th>
                            <th>P2</th>
                            <th>P3</th>
                            <th>Promedio</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($calificaciones as $cal): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cal->apellido_paterno . ' ' . $cal->alumno_nombre); ?></td>
                            <td><?php echo htmlspecialchars($cal->nombre_materia); ?></td>
                            <td><small><?php echo htmlspecialchars($cal->docente_apellido . ' ' . $cal->docente_nombre); ?></small></td>
                            <td class="text-center"><?php echo number_format($cal->parcial_1, 2); ?></td>
                            <td class="text-center"><?php echo number_format($cal->parcial_2, 2); ?></td>
                            <td class="text-center"><?php echo number_format($cal->parcial_3, 2); ?></td>
                            <td class="text-center fw-bold <?php echo ($cal->promedio < 6) ? 'text-danger' : 'text-success'; ?>">
                                <?php echo number_format($cal->promedio, 2); ?>
                            </td>
                            <td><?php echo htmlspecialchars($cal->observaciones); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
