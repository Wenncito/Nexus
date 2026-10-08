<?php
require_once '../config/database.php';
require_once '../includes/header.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM alumnos WHERE id = ?");
$stmt->execute([$id]);
$alumno = $stmt->fetch();

if (!$alumno) {
    header("Location: index.php");
    exit();
}
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detalles del Alumno</h2>
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-user-graduate"></i> Información de <?php echo htmlspecialchars($alumno->nombre); ?></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%" class="bg-light">Matrícula</th>
                            <td><?php echo htmlspecialchars($alumno->matricula); ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Nombre Completo</th>
                            <td><?php echo htmlspecialchars($alumno->nombre . ' ' . $alumno->apellido_paterno . ' ' . $alumno->apellido_materno); ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Fecha de Nacimiento</th>
                            <td><?php echo htmlspecialchars($alumno->fecha_nacimiento); ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Sexo</th>
                            <td><?php echo htmlspecialchars($alumno->sexo); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%" class="bg-light">Correo Electrónico</th>
                            <td><?php echo htmlspecialchars($alumno->correo); ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Teléfono</th>
                            <td><?php echo htmlspecialchars($alumno->telefono); ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Grupo Asignado</th>
                            <td><?php echo htmlspecialchars($alumno->grupo_asignado); ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Estado</th>
                            <td>
                                <?php if($alumno->estado == 'Activo'): ?>
                                    <span class="badge bg-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactivo</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="mt-4 text-center">
                <a href="editar.php?id=<?php echo $alumno->id; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Editar Datos</a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
