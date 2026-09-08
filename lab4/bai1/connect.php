<?php

$dsn = 'mysql:host=127.0.0.1;dbname=lab4_nts;charset=utf8';
$username = 'root';
$password = 'sa123';
try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'connect failed: '.$e->getMessage();
}
