<?php

require_once '../src/Controllers/login/key.php';
require_once '../vendor/autoload.php';
 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (isset($_GET['deslogar'])) {

unset($_COOKIE['auth_token']);

setcookie("auth_token", "", [
    'expires'  => time() - 3600,
    'path'     => '/',
    'httponly' => true,
    'secure'   => false,
    'samesite' => 'Lax'
]);
}