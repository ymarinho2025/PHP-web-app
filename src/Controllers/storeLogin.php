<?php
require_once 'db.php';
require_once 'key.php';
require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $senha = $_POST['password'];
    $hash = hash('sha256', $senha);

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $payload = [
            "iat" => time(),
            "exp" => time() + 3600,
            "id" => $result->fetch_assoc()['id']
            
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        setcookie("auth_token", $jwt, [
            'expires' => time() + 3600,
            'path' => '/',
            'httponly' => true,
            'secure' => false,
            'samesite' => 'Lax'
        ]);

        header("Location: /");
        exit;
    } else {
        echo "Email ou senha incorretos.";
    }
}