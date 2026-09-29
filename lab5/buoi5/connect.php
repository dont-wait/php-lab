<?php
    $dsn = 'mysql:host=localhost;dbname=lab3_shop;charset=utf8';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Kết nối cơ sở dữ liệu thành công - Nguyễn Tấn Sang";
    } catch (PDOException $e) {
        echo "Kết nối cơ sở dữ liệu thất bại - Nguyễn Tấn Sang: " . $e->getMessage();
    }
?>