<?php
require_once '../src/Controllers/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {

    $id = $_POST['id'] ?? null;

    if (!$id || !is_numeric($id)) {
        header("Location: admin.php?msg=id_invalido");
        exit();
    }

    $id = (int)$id;

    $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");

    if (!$stmt) {
        header("Location: admin.php?msg=erro_prepare");
        exit();
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: admin.php?msg=deletado");
        exit();
    } else {
        $stmt->close();
        header("Location: admin.php?msg=erro_delete");
        exit();
    }
}
?>