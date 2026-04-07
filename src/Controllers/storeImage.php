<?php
require_once 'db.php';
require_once 'key.php';
require_once 'base64.php';
require_once '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$userId = null;

if (isset($_COOKIE['auth_token'])) {
    try {
        $decoded = JWT::decode($_COOKIE['auth_token'], new Key($key, 'HS256'));
        $userId = $decoded->id;
    } catch (Exception $e) {
        die("Usuário não autenticado.");
    }
}

if (
    isset($_POST['namefotos']) &&
    isset($_POST['dia']) &&
    isset($_POST['mes']) &&
    isset($_POST['ano']) &&
    isset($_POST['upload']) &&
    isset($_FILES['fotos']) &&
    $_FILES['fotos']['error'] === UPLOAD_ERR_OK &&
    $userId !== null
) {
    $nome = trim($_POST['namefotos']);
    $dia = (int) $_POST['dia'];
    $mes = (int) $_POST['mes'];
    $ano = (int) $_POST['ano'];
    
    if ($base64Image) {
        // Inserção do novo usuário
        $stmt = $mysqli->prepare("INSERT INTO midia (nome, dia, mes, ano, imagem, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiisi", $nome, $dia, $mes, $ano, $base64Image, $userId);
        try {
            if ($stmt->execute()) {
                echo "Midia salva com sucesso!";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                echo "Já existe uma mídia com esse nome nessa mesma data.";
            } else {
                echo "Erro ao registrar Midia: " . $e->getMessage();
            }
        }

        $stmt->close();
    } else {
        echo "Erro: a imagem não foi convertida para base64.";
    }
}
?>