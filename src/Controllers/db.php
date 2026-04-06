<?php

$host = 'localhost';
$port = 3306;
$db   = 'edson';
$user = 'root';
$pass = 'wasd';

$mysqli = mysqli_connect($host, $user, $pass, $db, $port);

return $mysqli;
?>