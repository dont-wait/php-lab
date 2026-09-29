-- Dành cho cài đặt mới; không xóa bảng hoặc dữ liệu đã có.
CREATE DATABASE IF NOT EXISTS lab4_nts CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lab4_nts;
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    birthday DATE NULL
);
