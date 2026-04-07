<?php

$host = $_ENV['DB_HOST'] ?? 'localhost';
$port = (int)($_ENV['DB_PORT'] ?? 3306);
$db   = $_ENV['DB_NAME'] ?? 'edson';
$user = $_ENV['DB_USER'] ?? 'root';
$pass = $_ENV['DB_PASS'] ?? 'wasd';

$mysqli = mysqli_connect($host, $user, $pass, $db, $port);

if (!$mysqli) {
    die("Erro na conexão: " . mysqli_connect_error());
}

return $mysqli;