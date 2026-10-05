<?php
// Lab 4: PDO và ERRMODE_EXCEPTION; Lab 5: dùng lại kết nối cho các câu SQL.
// Ref: lab4/bai1/connect.php; lab5/buoi5/connect.php.
$config = require __DIR__.'/config.php';
$conn = new PDO(
    "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset=utf8mb4",
    $config['username'], $config['password'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     PDO::ATTR_EMULATE_PREPARES => false]
);
// Không echo ở đây: API cần trả JSON nguyên vẹn, không lẫn thông báo kết nối.
