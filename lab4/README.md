# Lab 4 — MySQL và PDO

Ứng dụng ở `bai1/`, dùng database `lab4_nts` theo cấu hình hiện tại trong `bai1/connect.php`.

## Chuẩn bị và chạy

1. Trong thư mục `lab4`, chạy `docker compose up -d`.
2. Mở phpMyAdmin tại `http://localhost:6060` (root / sa123).
   - Database đã có bảng `students`: import **một lần** `sql/08_add_birthday.sql` để thêm cột ngày sinh. Không chạy lại nếu cột đã tồn tại.
   - Cài mới: import `sql/database.sql`, đã bao gồm cột ngày sinh; không cần chạy file ALTER.
3. Chạy `php -S 127.0.0.1:8000 -t bai1` (hoặc `nix develop --command php -S 127.0.0.1:8000 -t bai1`).
4. Mở `http://localhost:8000/list_students.php`.

## Phần hoàn thiện từ bài 7

- **Bài 7, 9:** tìm theo tên, phân trang 5 sinh viên/trang; giữ từ khóa và sắp xếp khi chuyển trang. Tìm kiếm mới trở về trang 1, trang ngoài phạm vi được đưa về trang hợp lệ, có thông báo khi rỗng.
- **Bài 8:** cột `birthday` kiểu DATE, hiển thị trong danh sách và nhập/cập nhật qua form thêm/sửa. Dữ liệu cũ được giữ nguyên với ngày sinh NULL; mở Sửa để cập nhật ngày sinh thực tế.
- **Bài 10:** các truy vấn ứng dụng dùng `prepare`, `execute`/`bindValue`; LIMIT/OFFSET được bind kiểu số nguyên.
- **Bài 11:** chọn sắp xếp tên/email tăng hoặc giảm, ID làm thứ tự phụ ổn định. Tên cột/chiều được kiểm tra bằng danh sách cho phép vì không thể bind tên cột SQL.

Để kiểm tra phân trang, thêm ít nhất 6 sinh viên qua form; tìm một nhóm tên có trên 5 kết quả rồi chuyển trang và đổi sắp xếp. Kiểm tra sửa ngày sinh, để trống ngày sinh và email trùng.
