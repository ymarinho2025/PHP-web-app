<?php
require_once '../src/Controllers/db.php';
require_once '../src/Controllers/login/key.php';
require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getClientIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        return trim($ipList[0]);
    }

    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function ensureLoginHistoryTableExists($mysqli)
{
    $createTableSql = "CREATE TABLE IF NOT EXISTS user_logins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        ip VARCHAR(45) NOT NULL,
        login_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_user_id(user_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    $mysqli->query($createTableSql);
}

function saveUserLoginIp($mysqli, $userId, $ip)
{
    ensureLoginHistoryTableExists($mysqli);

    $stmt = $mysqli->prepare("INSERT INTO user_logins (user_id, ip) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("is", $userId, $ip);
        $stmt->execute();
        $stmt->close();
    }
}

// Só tenta logar se for POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['password'] ?? '';
    $hash  = hash('sha256', $senha);

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $ip   = getClientIpAddress();
        saveUserLoginIp($mysqli, $user['id'], $ip);

        $payload = [
            "iat"   => time(),
            "exp"   => time() + 3600,
            "id"    => $user['id'],
            "roles" => $user['roles']
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        setcookie("auth_token", $jwt, [
            'expires'  => time() + 3600,
            'path'     => '/',
            'httponly' => true,
            'secure'   => false,
            'samesite' => 'Lax'
        ]);

        header('Location: /home.php');
        exit();

    } else {
        $loginErro = "Email ou senha incorretos.";
    }

} else {
    // GET sem POST: só redireciona para home se o cookie for válido
    // (usuário já logado tentando acessar /login.php)
    $auth_token = $_COOKIE['auth_token'] ?? null;

    if ($auth_token) {
        try {
            JWT::decode($auth_token, new Key($key, 'HS256'));
            // Token válido: manda para home
            header('Location: /home.php');
            exit();
        } catch (Exception $e) {
            // Token inválido ou expirado: limpa o cookie e deixa acessar o login
            setcookie("auth_token", "", [
                'expires'  => time() - 3600,
                'path'     => '/',
                'httponly' => true,
                'secure'   => false,
                'samesite' => 'Lax'
            ]);
            unset($_COOKIE['auth_token']);
        }
    }
}