<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require_once '../src/Controllers/auth.php'; ?>
</head>
<body>
    <h1>Olá, mundo!</h1>
    <p>Bem-vindo ao meu sistema de autenticação!</p>

    arquivos=?
    upload=1

    <form action="index.php" method="POST">
        <input type="hidden" name="upload" value="1">
        <input type="file" name="fotos">
        <button type="submit">Enviar</button>
    </form>

    <form action="login.php" method="GET">
        <button type="submit" name="deslogar" value="1">Deslogar</button>
    </form>
</body>
</html>