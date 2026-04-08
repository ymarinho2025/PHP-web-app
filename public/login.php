<?php
require_once '../src/Controllers/login/storeLogin.php';
require_once '../src/Controllers/login/deslogar.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <script src="js/script.js" defer></script>
    
</head>
<body>

    <button class="btn-menu" id="btn-menu">☰ Menu</button>
    <ul class="menu" id="menu">
        <li><a href="/home.php">INICIO</a></li>
        <li><a href="/register.php">REGISTRO</a></li>
        <li><a href="/login.php">LOGIN</a></li>
        <li><a href="/fotos.php">FOTOS</a></li>
        <?php 
        if (isset($_COOKIE['auth_token'])) {
            try {
                $decoded = JWT::decode($_COOKIE['auth_token'], new Key($key, 'HS256'));
                $roles = $decoded->roles;
                if ($roles == 3) {
                    echo '<li><a href="/admin.php">ADMIN</a></li>';
                    }
                } catch (Exception $e) {
            } 
        }
        ?>
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