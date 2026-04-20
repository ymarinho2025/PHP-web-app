<?php
require_once '../src/Controllers/db.php';
require_once '../src/Controllers/login/key.php';
require_once '../src/Controllers/image/base64.php';
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
        $userId = $decoded->id;
    } catch (Exception $e) {
        die("Usuário não autenticado.");
    }
}

if (
//  isset($_POST['dia']) &&
    isset($_POST['mes']) &&
    isset($_POST['ano']) &&
    $userId !== null
) {
//  $dia = (int) $_POST['dia'];
    $mes = (int) $_POST['mes'];
    $ano = (int) $_POST['ano'];

    $stmt = $mysqli->prepare(" SELECT nome, imagem FROM midia WHERE mes = ? AND ano = ? AND user_id = ? ORDER BY id DESC");

    $stmt->bind_param("iii", $mes, $ano, $userId);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $imagens[] = $row;
    }

    $stmt->close();
}
?>