-- Chạy một lần trên database hiện có, trước khi sử dụng form thêm/sửa mới.
USE lab4_nts;
ALTER TABLE students ADD COLUMN birthday DATE NULL;
-- Dữ liệu cũ giữ NULL. Mở Sửa trên danh sách để cập nhật ngày sinh thực tế.
