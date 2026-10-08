<?php
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM alumnos WHERE id = ?");
        $stmt->execute([$id]);
    } catch(PDOException $e) {
        // En caso de error de llave foránea u otro
    }
}
header("Location: index.php");
exit();
?>
