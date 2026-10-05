-- Dữ liệu dùng chung: chép từ mục III của đề 01.
-- Dùng UTF-8 cho phiên import để giữ đúng dữ liệu tiếng Việt.
SET NAMES utf8mb4;
CREATE DATABASE week7_device CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE week7_device;

CREATE TABLE devices (
device_id INT AUTO_INCREMENT PRIMARY KEY,
device_name VARCHAR(120) NOT NULL,

category VARCHAR(60) NOT NULL,
price DECIMAL(12,2) NOT NULL,
stock INT NOT NULL
);

CREATE TABLE borrows (
borrow_id INT AUTO_INCREMENT PRIMARY KEY,
student_name VARCHAR(100) NOT NULL,
borrow_date DATE NOT NULL
);

CREATE TABLE borrow_details (
borrow_id INT,
device_id INT,
quantity INT NOT NULL,
PRIMARY KEY (borrow_id, device_id),
FOREIGN KEY (borrow_id) REFERENCES borrows(borrow_id),
FOREIGN KEY (device_id) REFERENCES devices(device_id)
);

INSERT INTO devices(device_name, category, price, stock) VALUES
('Laptop Dell Latitude', 'Laptop', 18500000, 8),
('Laptop HP ProBook', 'Laptop', 17200000, 6),
('Máy chiếu Epson', 'Trình chiếu', 12900000, 4),
('Webcam Logitech', 'Phụ kiện', 2150000, 12),
('Bộ micro USB', 'Phụ kiện', 3200000, 10),
('Màn hình 24 inch', 'Màn hình', 3900000, 7);

INSERT INTO borrows(student_name, borrow_date) VALUES
('Nguyễn An', '2026-09-20'),
('Trần Bình', '2026-09-21'),
('Lê Chi', '2026-09-22'),
('Phạm Dũng', '2026-09-23');

INSERT INTO borrow_details(borrow_id, device_id, quantity) VALUES
(1,1,1),(1,4,2),(2,3,1),(2,4,1),
(3,2,1),(3,5,2),(4,1,1),(4,6,2);
