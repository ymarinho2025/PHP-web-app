<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="form.css">
    <script src="script.js" defer></script>
    <?php require_once '../src/Controllers/storeRegister.php'; ?>
</head>
<body>

    <button class="btn-menu" id="btn-menu">☰ Menu</button>
    <ul class="menu" id="menu">
        <li><a href="/">INICIO</a></li>
        <li><a href="/register.php">REGISTRO</a></li>
        <li><a href="/login.php">LOGIN</a></li>
        <li><a href="/fotos.php">FOTOS</a></li>
    </ul>

<form action="register.php" method="POST">
    <fieldset>
        <legend>Registre sua conta</legend>
        <input type="text" name="name" placeholder="Name" required autofocus>
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Register">
    </fieldset>
</form>

</body>
</html>