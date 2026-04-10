<?php
require_once '../src/Controllers/db.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $nome  = trim($_POST['name'] ?? '');
    $senha = $_POST['password'] ?? '';

    if ($email === '' || $nome === '' || $senha === '') {
        http_response_code(400);
        $mensagem = "Todos os campos são obrigatórios.";
    }

    elseif (mb_strlen($nome) < 2 || mb_strlen($nome) > 50) {
        http_response_code(400);
        $mensagem = "O nome deve ter entre 2 e 50 caracteres.";
    }

    elseif (mb_strlen($email) > 100) {
        http_response_code(400);
        $mensagem = "Email muito longo.";
    }

    elseif (strlen($senha) < 8) {
        http_response_code(400);
        $mensagem = "A senha deve conter no mínimo 8 caracteres.";
    }

    elseif (!preg_match('/^[\p{L}\s.\'-]+$/u', $nome)) {
        http_response_code(400);
        $mensagem = "Nome inválido.";
    }

    elseif (preg_match('/[<>]/', $nome) || preg_match('/[<>]/', $email)) {
        http_response_code(400);
        $mensagem = "Entrada inválida.";
    }

    elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        http_response_code(400);
        $mensagem = "Email inválido.";
    }

    else {
        $hash = hash('sha256', $senha);

        $stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            http_response_code(409);
            $mensagem = "Email já cadastrado.";
        } else {
            $stmt = $mysqli->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
            $stmt->bind_param('sss', $nome, $email, $hash);

            if ($stmt->execute()) {
                http_response_code(200);
                $mensagem = "Usuário registrado com sucesso!";
            } else {
                http_response_code(500);
                $mensagem = "Erro ao registrar.";
            }
        }
    }
}
?>