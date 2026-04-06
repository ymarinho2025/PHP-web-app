<?php require_once '../src/Controllers/storeLogin.php';?>
<?php require_once '../src/Controllers/deslogar.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="form.css">
    <script src="script.js" defer></script>
    
</head>
<body>

    <button class="btn-menu" id="btn-menu">☰ Menu</button>
    <ul class="menu" id="menu">
        <li><a href="/">INICIO</a></li>
        <li><a href="/register.php">REGISTRO</a></li>
        <li><a href="/login.php">LOGIN</a></li>
        <li><a href="/fotos.php">FOTOS</a></li>
    </ul>

    <form action="login.php" method="POST">
        <fieldset>
            <legend>Entre com seus dados de acesso</legend>
            <label for="email">Email:</label>
            <input type="text" name="email" placeholder="Email" required autofocus>
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </fieldset>
    </form>
</body>
</html>