<?php

require_once 'key.php';
require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$auth_token = $_COOKIE['auth_token'] ?? null;

try {
    if (!$auth_token) {
        throw new Exception("Token não encontrado");
    }
    $decoded = JWT::decode($auth_token, new Key($key, 'HS256'));
    echo "Usuário Email: " . $decoded->user_email;
    
} catch (Exception $e) {
    echo "<script>window.location.href = '/login.php';</script>";
    exit();
}