<?php

require_once '../src/Controllers/db.php';
require_once '../src/Controllers/login/key.php';
require_once '../vendor/autoload.php';

$email = trim($_POST['email'] ?? '');
$nome  = trim($_POST['name'] ?? '');
$senha = $_POST['password'] ?? '';
$hash = hash('sha256', $senha);   

    $stmt = $mysqli->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    // achar maneira de mostrar mensagem de email já cadastrado    
    // echo "Email já cadastrado.";
    } else {

        $stmt = $mysqli->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $hash);
        if ($stmt->execute()) {
            // achar maneira de mostrar mensagem de sucesso'
            // echo "Usuário registrado com sucesso!";
        } else {
        // achar maneira de mostrar mensagem de erro   
        // echo "Erro ao registrar usuário: " . $stmt->error;
        }
    }
?>