<?php
require_once 'db.php';
require_once 'key.php';
require_once 'base64.php';
require_once '../vendor/autoload.php';
require_once '../src/Controllers/db.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$imagens = [];
$userId = null;

$userId = null;

if (isset($_COOKIE['auth_token'])) {
    try {
        $decoded = JWT::decode($_COOKIE['auth_token'], new Key($key, 'HS256'));
        $email = $decoded->user_email;

        $stmtUser = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
        $stmtUser->bind_param("s", $email);
        $stmtUser->execute();
        $resultUser = $stmtUser->get_result();

        if ($rowUser = $resultUser->fetch_assoc()) {
            $userId = (int) $rowUser['id'];
        }

        $stmtUser->close();
    } catch (Exception $e) {
        die("Usuário não autenticado.");
    }
}

if (
    isset($_POST['dia']) &&
    isset($_POST['mes']) &&
    isset($_POST['ano']) &&
    $userId !== null
) {
    $dia = (int) $_POST['dia'];
    $mes = (int) $_POST['mes'];
    $ano = (int) $_POST['ano'];

    $stmt = $mysqli->prepare(" SELECT nome, imagem FROM midia WHERE dia = ? AND mes = ? AND ano = ? AND user_id = ? ORDER BY id DESC");

    $stmt->bind_param("iiii", $dia, $mes, $ano, $userId);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $imagens[] = $row;
    }

    $stmt->close();
}
?>