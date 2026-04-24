<?php

$pdo = require '../src/Controllers/db.php';
require_once '../src/Controllers/login/key.php';
require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$auth_token = $_COOKIE['auth_token'] ?? null;

try {
    if (!$auth_token) {
        throw new Exception("Token não encontrado");
    }

    $decoded = JWT::decode($auth_token, new Key($key, 'HS256'));
    $userId = (int) $decoded->id;

    $stmtUser = $pdo->prepare("SELECT name FROM users WHERE id = :id LIMIT 1");
    $stmtUser->execute([
        ':id' => $userId
    ]);

    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("Usuário não encontrado");
    }

    $userName = $user['name'];

} catch (Exception $e) {
    setcookie("auth_token", "", time() - 3600, "/");

    echo "<script>window.location.href = '/login.php';</script>";
    exit();
}
