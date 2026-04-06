<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <?php require_once '../src/Controllers/auth.php'; ?>
</head>
<body>

    <button class="btn-menu" id="btn-menu">☰ Menu</button>
    <ul class="menu" id="menu">
        <li><a href="/">INICIO</a></li>
        <li><a href="/register.php">REGISTRO</a></li>
        <li><a href="/login.php">LOGIN</a></li>
        <li><a href="/fotos.php">FOTOS</a></li>
    </ul>

    <form action="login.php" method="GET">
        <button type="submit" name="deslogar" value="1">Deslogar</button>
    </form>
</body>
</html>