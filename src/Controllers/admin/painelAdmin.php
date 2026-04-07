<?php
require_once '../src/Controllers/db.php';

$usuarios = [];
$total_usuarios = 0;
$admins = 0;
$professores = 0;
$usuarios_comuns = 0;

$result = $mysqli->query("SELECT id, name, email, roles FROM users ORDER BY id DESC");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}

$total_usuarios = count($usuarios);

foreach ($usuarios as $usuario) {
    $role = (int)$usuario['roles'];

    if ($role === 3) {
        $admins++;
    } elseif ($role === 2) {
        $professores++;
    } else {
        $usuarios_comuns++;
    }
}