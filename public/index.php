<?php
require_once '../vendor/autoload.php';
require_once '../src/Controllers/login/auth.php';

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
    <script src="js/script.js" defer></script>
</head>
<body>

    <button class="btn-menu" id="btn-menu">☰ Menu</button>
    <ul class="menu" id="menu">
        <li><a href="/">INICIO</a></li>
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

    <form action="login.php" method="GET">
        <button type="submit" name="deslogar" value="1">Deslogar</button>
    </form>
</body>
</html>