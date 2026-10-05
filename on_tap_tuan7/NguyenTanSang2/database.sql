-- Dữ liệu dùng chung: chép từ mục III của đề 02.
-- Dùng UTF-8 cho phiên import để giữ đúng dữ liệu tiếng Việt.
SET NAMES utf8mb4;
CREATE DATABASE week7_workshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE week7_workshop;

CREATE TABLE workshops (
workshop_id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(120) NOT NULL,
topic VARCHAR(60) NOT NULL,

fee DECIMAL(12,2) NOT NULL,
capacity INT NOT NULL
);

CREATE TABLE students (
student_id INT AUTO_INCREMENT PRIMARY KEY,
full_name VARCHAR(100) NOT NULL,
email VARCHAR(120) UNIQUE NOT NULL
);

CREATE TABLE registrations (
reg_id INT AUTO_INCREMENT PRIMARY KEY,
student_id INT NOT NULL,
workshop_id INT NOT NULL,
registered_at DATE NOT NULL,
status VARCHAR(20) NOT NULL,
FOREIGN KEY (student_id) REFERENCES students(student_id),
FOREIGN KEY (workshop_id) REFERENCES workshops(workshop_id)
);

INSERT INTO workshops(title, topic, fee, capacity) VALUES
('PHP Web Basics', 'Web', 350000, 25),
('OOP with PHP', 'Web', 450000, 20),
('JavaScript DOM', 'Front-end', 400000, 30),
('AJAX with Fetch', 'Front-end', 500000, 18),
('MySQL PDO', 'Database', 550000, 22),
('SQL Analytics', 'Database', 600000, 15);

INSERT INTO students(full_name, email) VALUES
('Nguyễn Minh', 'minh@example.com'),
('Trần Lan', 'lan@example.com'),
('Lê Khoa', 'khoa@example.com'),
('Phạm Vy', 'vy@example.com');

INSERT INTO registrations(student_id, workshop_id, registered_at, status) VALUES
(1,1,'2026-09-20','confirmed'),
(1,5,'2026-09-21','confirmed'),
(2,3,'2026-09-21','confirmed'),
(2,4,'2026-09-22','cancelled'),
(3,2,'2026-09-22','confirmed'),
(3,5,'2026-09-23','confirmed'),
(4,3,'2026-09-23','confirmed'),
(4,6,'2026-09-24','confirmed');
