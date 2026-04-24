<?php

// db.php - Conexão PDO com PostgreSQL/Neon
// Recomendo configurar DATABASE_URL no ambiente da hospedagem.
// Exemplo:
// DATABASE_URL=postgresql://usuario:senha@host/neondb?sslmode=require

$databaseUrl = $_ENV['DATABASE_URL'] ?? getenv('DATABASE_URL');

if (!$databaseUrl) {
    die("Erro: variável DATABASE_URL não configurada.");
}

$parsed = parse_url($databaseUrl);

if (!$parsed || empty($parsed['host']) || empty($parsed['user']) || empty($parsed['path'])) {
    die("Erro: DATABASE_URL inválida.");
}

$host = $parsed['host'];
$port = $parsed['port'] ?? 5432;
$user = rawurldecode($parsed['user']);
$pass = isset($parsed['pass']) ? rawurldecode($parsed['pass']) : '';
$db   = ltrim($parsed['path'], '/');

$dsn = "pgsql:host={$host};port={$port};dbname={$db};sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    return $pdo;
} catch (PDOException $e) {
    die("Erro na conexão PostgreSQL: " . $e->getMessage());
}
