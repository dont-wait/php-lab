# Backup MySQL Lab 4

`lab4_nts_20260915_004408.sql` là bản xuất thực tế từ MySQL của database `lab4_nts`, gồm cấu trúc bảng `students` và dữ liệu tại thời điểm xuất. File dùng UTF-8, có CREATE DATABASE / USE và lệnh INSERT dữ liệu.

Bản này được xuất **trước khi thêm cột birthday**. Sau khi khôi phục, chạy một lần `../sql/08_add_birthday.sql` để dùng form ngày sinh của bài 8.

## Khôi phục bằng phpMyAdmin

1. Khởi động dịch vụ: `docker compose up -d` trong thư mục `lab4`.
2. Mở `http://localhost:6060`, đăng nhập root / sa123.
3. Chọn **Import (Nhập)**, chọn file `.sql` này, rồi bấm **Go (Thực hiện)**.
4. File tự chọn database `lab4_nts`. Bảng `students` hiện có sẽ được thay thế bằng dữ liệu trong bản backup; hãy xuất bản mới trước nếu cần giữ dữ liệu hiện tại.

Đã kiểm tra lệnh mysqldump thành công và file có cấu trúc, INSERT, dấu kết thúc dump. Chưa thử khôi phục qua giao diện phpMyAdmin.
