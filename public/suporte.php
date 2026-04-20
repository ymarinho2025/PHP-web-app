<?php
require_once '../src/Controllers/db.php';
require_once '../src/Controllers/login/auth.php';
require_once '../src/Controllers/login/deslogar.php';

// auth.php já deve garantir que $userId exista
// se quiser segurança extra:
if (!isset($userId)) {
    header("Location: /login.php");
    exit();
}

// ========================
// CRIA TABELA (caso não exista)
// ========================
$mysqli->query("
CREATE TABLE IF NOT EXISTS suporte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    assunto VARCHAR(255) NOT NULL,
    mensagem TEXT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pendente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id)
)
");

// ========================
// ENVIO DE MENSAGEM
// ========================
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assunto = trim($_POST['assunto'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    if ($assunto === '' || $mensagem === '') {
        $msg = "Preencha todos os campos.";
    } elseif (mb_strlen($assunto) > 255) {
        $msg = "O assunto é muito longo.";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO suporte (user_id, assunto, mensagem) VALUES (?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("iss", $userId, $assunto, $mensagem);

            if ($stmt->execute()) {
                $msg = "Mensagem enviada com sucesso!";
            } else {
                $msg = "Erro ao enviar mensagem.";
            }

            $stmt->close();
        } else {
            $msg = "Erro interno ao preparar a mensagem.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suporte</title>
  <link rel="stylesheet" href="./css/estilo.css">
</head>
<body class="light suporte-page">

<header>
  <div class="brand">
    <span class="brand-icon">E</span>
    <span class="brand-text">Grade</span>
  </div>

  <div class="header-actions">
    <a href="/home.php"><button type="button">Voltar</button></a>

    <form method="GET" style="display:inline;">
      <button type="submit" name="deslogar" value="1">Sair</button>
    </form>

    <button id="toggleTema" type="button">🌙</button>
  </div>
</header>

<div class="container">
  <div class="box suporte-box">
    <h2>Suporte</h2>

    <form method="POST">
      <input type="text" name="assunto" placeholder="Assunto" required maxlength="255">

      <textarea name="mensagem" rows="5" placeholder="Mensagem" required></textarea>

      <button class="btn-suporte" type="submit">Enviar</button>
    </form>

    <?php if ($msg): ?>
      <p><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
  </div>
</div>

<script src="./js/app.js"></script>
</body>
</html>