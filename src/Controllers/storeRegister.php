<?php
// primeiro passo pegar as variaveis que recebi via post
// segundo passo jogar as variaveis no banco de dados ( )
// terceiro passo verificar se não existe usuario cadastrado com o mesmo email (se existir, mostrar uma mensagem de erro)

require_once 'db.php';

if (isset($_POST['email']) && isset($_POST['name']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $nome = $_POST['name'];
    $senha = $_POST['password'];
    $hash = hash('sha256', $senha);

// Consulta para verificar existência

    $stmt = $mysqli->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // 's' enforces string type
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email já cadastrado.";
    } else {
        // Inserção do novo usuário
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