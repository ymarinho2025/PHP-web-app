<?php

require_once '../src/Controllers/db.php';
require_once '../src/Controllers/login/key.php';
require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$auth_token = $_COOKIE['auth_token'] ?? null;

try {
    if (!$auth_token) {
        throw new Exception("Token não encontrado");
    }

    $decoded = JWT::decode($_COOKIE['auth_token'], new Key($key, 'HS256'));
    $userId = $decoded->id;

    $stmtUser = $mysqli->prepare("SELECT name FROM users WHERE id = ?");
    $stmtUser->bind_param("i", $userId);
    $stmtUser->execute();
    $result = $stmtUser->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        throw new Exception("Usuário não encontrado");
    }

    $userName = $user['name'];

    // Exemplo de uso:
    // echo "Usuário atual: " . htmlspecialchars($userName, ENT_QUOTES, 'UTF-8');ENT_QUOTES, 'UTF-8');
    
} catch (Exception $e) {
    setcookie("auth_token", "", time() - 3600, "/");

    echo "<script>window.location.href = '/login.php';</script>";
    exit();
}