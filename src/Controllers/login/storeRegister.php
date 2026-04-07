<?php

require_once '../src/Controllers/db.php';
require_once '../src/Controllers/login/key.php';
require_once '../vendor/autoload.php';

if (isset($_POST['email']) && isset($_POST['name']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $nome = $_POST['name'];
    $senha = $_POST['password'];

    if (strlen($senha) < 8) {
    echo "A senha deve conter no mínimo 8 caracteres.";
    exit;
}

    $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/"; // Matches the whole word "web", case-insensitive
    $invalidCharsRegex = "/[()\/\\<>]/";

    if (!preg_match($emailRegex, $email)) {
    echo "Email Invalido";
}
    if (preg_match($invalidCharsRegex, $nome)) {
    echo "O nome contém caracteres inválidos: ( ) / \\ < >";
}
    $hash = hash('sha256', $senha);
    
    $stmt = $mysqli->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email já cadastrado.";
    } else {

        $stmt = $mysqli->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $hash);
        if ($stmt->execute()) {
            echo "Usuário registrado com sucesso!";
        } else {
            echo "Erro ao registrar usuário: " . $stmt->error;
        }
    }
}
?>