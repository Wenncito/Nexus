<?php
require_once 'config/database.php';
require_once 'includes/header.php';

// Obtener conteos para el dashboard
$totalAlumnos = $pdo->query("SELECT COUNT(*) FROM alumnos")->fetchColumn();
$totalDocentes = $pdo->query("SELECT COUNT(*) FROM docentes")->fetchColumn();
$totalMaterias = $pdo->query("SELECT COUNT(*) FROM materias")->fetchColumn();
$totalGrupos = $pdo->query("SELECT COUNT(*) FROM grupos")->fetchColumn();
?>

<div class="container-fluid">
    <h2 class="mb-4">Dashboard</h2>

    <div class="row">
        <!-- Tarjeta Alumnos -->
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white card-stats position-relative overflow-hidden h-100">
                <div class="card-body">
                    <h5 class="card-title">Alumnos</h5>
                    <h2 class="display-4"><?php echo $totalAlumnos; ?></h2>
                    <i class="fas fa-user-graduate icon"></i>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="alumnos/" class="text-white text-decoration-none">Ver Detalles <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Docentes -->
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white card-stats position-relative overflow-hidden h-100">
                <div class="card-body">
                    <h5 class="card-title">Docentes</h5>
                    <h2 class="display-4"><?php echo $totalDocentes; ?></h2>
                    <i class="fas fa-chalkboard-teacher icon"></i>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="docentes/" class="text-white text-decoration-none">Ver Detalles <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Materias -->
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-dark card-stats position-relative overflow-hidden h-100">
                <div class="card-body">
                    <h5 class="card-title">Materias</h5>
                    <h2 class="display-4"><?php echo $totalMaterias; ?></h2>
                    <i class="fas fa-book icon"></i>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="materias/" class="text-dark text-decoration-none">Ver Detalles <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Grupos -->
        <div class="col-md-3 mb-4">
            <div class="card bg-danger text-white card-stats position-relative overflow-hidden h-100">
                <div class="card-body">
                    <h5 class="card-title">Grupos</h5>
                    <h2 class="display-4"><?php echo $totalGrupos; ?></h2>
                    <i class="fas fa-users icon"></i>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <a href="grupos/" class="text-white text-decoration-none">Ver Detalles <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Accesos Rápidos</h5>
                </div>
                <div class="card-body">
                    <a href="alumnos/crear.php" class="btn btn-outline-primary m-2"><i class="fas fa-plus"></i> Registrar Alumno</a>
                    <a href="docentes/crear.php" class="btn btn-outline-success m-2"><i class="fas fa-plus"></i> Registrar Docente</a>
                    <a href="materias/crear.php" class="btn btn-outline-warning m-2"><i class="fas fa-plus"></i> Registrar Materia</a>
                    <a href="grupos/crear.php" class="btn btn-outline-danger m-2"><i class="fas fa-plus"></i> Registrar Grupo</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
