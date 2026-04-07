<?php

require_once 'db.php';
require_once 'key.php';
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

    echo "Usuário atual: " . htmlspecialchars($result->fetch_assoc()['name'], ENT_QUOTES, 'UTF-8');
    
} catch (Exception $e) {
    echo "<script>window.location.href = '/login.php';</script>";
    exit();
}