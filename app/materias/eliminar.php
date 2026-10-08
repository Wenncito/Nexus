<?php
require_once '../config/database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM materias WHERE id = ?");
        $stmt->execute([$id]);
    } catch(PDOException $e) {
        // En caso de error de llave foránea
    }
}
header("Location: index.php");
exit();
?>
