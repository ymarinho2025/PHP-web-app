<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="form.css">
    <script src="script.js" defer></script>
    <?php require_once '../src/Controllers/auth.php'; ?>
    <?php require_once '../src/Controllers/base64.php'; ?>
    <?php require_once '../src/Controllers/storeImage.php'; ?>
    <?php require_once '../src/Controllers/getImage.php'; ?>
</head>
<body>
    <button class="btn-menu" id="btn-menu">☰ Menu</button>
    <ul class="menu" id="menu">
        <li><a href="/">INICIO</a></li>
        <li><a href="/register.php">REGISTRO</a></li>
        <li><a href="/login.php">LOGIN</a></li>
        <li><a href="/fotos.php">FOTOS</a></li>
    </ul>

    <form action="fotos.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Envie seu cartão resposta</legend>
            <label for="namefotos">Nome da foto:</label>
            <input type="text" name="namefotos" placeholder="Nome" autofocus>
            <label>Data da foto:</label>
            <input type="number" name="dia" placeholder="Dia" min="1" max="31" required>
            <input type="number" name="mes" placeholder="Mês" min="1" max="12" required>
            <input type="number" name="ano" placeholder="Ano" min="2000" max="2060" required>
            <input type="hidden" name="upload" value="1">
            <input type="file" name="fotos" accept="image/*">
            <input type="submit" value="Enviar">
        </fieldset>
    </form>
    <?php if (!empty($imagens)): ?>
        <h2>Imagens encontradas na mesma data</h2>

        <?php foreach ($imagens as $img): ?>
            <div style="margin-bottom: 20px;">
                <p><strong><?= htmlspecialchars($img['nome']) ?></strong></p>
                <img src="<?= htmlspecialchars($img['imagem']) ?>" alt="Imagem" width="300">
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="login.php" method="GET">
        <button class="btn-deslogar" type="submit" name="deslogar" value="1">Deslogar</button>
    </form>
</body>
</html>