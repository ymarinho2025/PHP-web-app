<?php
require_once '../src/Controllers/login/storeRegister.php';

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
    <script src="js/leter.js" defer></script>
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

<form id="registerForm"action="register.php" method="POST">
    <fieldset>
        <legend>Registre sua conta</legend>
        <input type="text" id="name" name="name" placeholder="Name" required autofocus>
        <input type="text" id="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <input type="submit" value="Register">
    </fieldset>
</form>

<script>
    document.querySelector("form").addEventListener("submit", function(event) {
    // Impede o envio do formulário
    event.preventDefault(); 

    // Suas validações ou lógica Ajax aqui
    console.log("Formulário não enviado.");
});
</script>

</body>
</html>