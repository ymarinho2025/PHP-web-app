<?php
require_once '../src/Controllers/login/storeRegister.php';
require_once '../src/Controllers/login/process.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
?>

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Grade | Registro</title>
    <link rel="stylesheet" href="./css/form.css">
    <script src="./js/leter.js" defer></script>
</head>
<body>

<div class="login-root">
    <aside class="side-left">
        <div class="egrade-logo">
            <span class="egrade-logo__icon">E</span>
            <span class="egrade-logo__text">Grade</span>
        </div>
    </aside>

    <section class="side-right">
        <div class="login-card">
            <div class="login-header">
                <div class="grid-overlay"></div>

                <div class="brand">
                    <span class="brand-icon">E</span>
                    <span class="brand-text">Grade</span>
                </div>

                <p class="brand-sub">Crie sua conta institucional</p>
            </div>

            <form id="registerForm"action="register.php" method="POST">
    <fieldset>
        <legend>Registre sua conta</legend>
        <input type="text" id="name" name="name" placeholder="Name" required autofocus>
        <input type="text" id="email" name="email" placeholder="Email" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <input type="submit" value="Register">
    </fieldset>
    <p class="form-link">Já tem uma conta?<a href="login.php">Entre aqui</a>
</form>

<script>
    document.querySelector("form").addEventListener("submit", function(event) {
    // Impede o envio do formulário
    event.preventDefault(); 

    // Suas validações ou lógica Ajax aqui
    console.log("Formulário não enviado.");
});
</script>
        </div>
    </section>
</div>

</body>
</html>