# Ôn tập tuần 7 - Lập trình mã nguồn mở

Bài giải hai đề PDF ở thư mục gốc, dựa trên **mã nguồn lab1–lab5 hiện có trong repository**. Mỗi câu có comment `Câu …`, `Lab …`, `Ref: …` ngay trong PHP/HTML/JS; đường dẫn trong comment tính từ gốc repository. Bảng bên dưới có link mở trực tiếp bài lab. Những phần kết hợp mới được giải thích riêng, không coi là bản chép nguyên mẫu của lab.

- [Đề 01 — Quản lý mượn thiết bị](NguyenTanSang1/README.md)
- [Đề 02 — Đăng ký workshop](NguyenTanSang2/README.md)

## Bộ kit Lab 1–5

[Bộ kit ôn tập](kit_lab1_lab5/README.md): từng lab có bản đồ bài gốc, mẫu code có comment, lỗi dễ gặp và bài tự luyện.

## Chạy bài

1. Dùng Compose có sẵn: từ gốc repo chạy `docker compose -f lab4/docker-compose.yml up -d`. phpMyAdmin ở `http://127.0.0.1:6060` (root / sa123). Hoặc mở MySQL/MariaDB riêng trên máy. Trong phpMyAdmin, import `database.sql` của từng đề; file đã có `CREATE DATABASE`, `USE`, bảng và dữ liệu đúng mục III của PDF. Import một lần trên CSDL mới để tránh trùng bảng/dữ liệu.
2. Sửa `config.php` trong **từng thư mục đề**: host, port, username, password. Mặc định `127.0.0.1:3306`, user `root`, mật khẩu `sa123` theo Compose lab4; tên CSDL lần lượt `week7_device` và `week7_workshop`.
3. Từ gốc repository chạy:

   ```sh
   php -S 127.0.0.1:8000 -t on_tap_tuan7
   ```

4. Mở `http://127.0.0.1:8000/NguyenTanSang1/` hoặc `http://127.0.0.1:8000/NguyenTanSang2/`. Mỗi trang đầu có link tới tất cả câu.

Cần PHP có extension `pdo_mysql`. Dùng Laragon cũng được: chép thư mục đề vào `www`, import SQL, sửa cấu hình rồi mở qua localhost. Các trang HTML dùng Fetch phải mở qua HTTP để gọi được PHP. Không cần Composer, Internet hoặc CDN. Mỗi thư mục đề chạy độc lập, không `require` mã từ lab.

## Bản đồ kiến thức chung

| Phần | Lab và file nên ôn | Điểm cần nhớ |
| --- | --- | --- |
| Form PHP (1.1 cả hai đề) | [Lab 1 bài 10](../lab1/bai10/info_process.php), [bài 17](../lab1/bai17/uppercase.php) | `$_POST`, `trim`, kiểm tra rỗng; đề thêm kiểm tra email bằng `filter_var`. Escape lúc xuất HTML. |
| OOP (1.2) | [Lab 2 bài 2](../lab2/bai2.php), [BankAccount](../lab2/bai6/BankAccount.php), [Book](../lab2/bai7/Book.php) | `private`, `__construct`, `$this`, getter, phương thức trả về số và phương thức hiển thị. |
| DOM/Event (1.3) | [Lab 3 bài 2](../lab3/bai2/index.js), [bài 3](../lab3/bai3/index.js) | Bắt sự kiện, `preventDefault`, lấy input, validation, `createElement`/`textContent`. |
| PDO + lọc GET (1.4) | [Lab 4 danh sách](../lab4/bai1/list_students.php), [kết nối](../lab4/bai1/connect.php) | `prepare` → `execute` → `fetchAll`; truyền giá trị qua placeholder. |
| Fetch + JSON (2.1) | [Lab 3 tìm kiếm JS](../lab3/bai7/index.js), [PHP JSON](../lab3/bai7/search.php), [đăng ký](../lab3/bai12/register.php) | Fetch → kiểm tra HTTP → JSON → cập nhật DOM; PHP đặt Content-Type. Ghép PDO của Lab 4 thay cho mảng mẫu. |
| Thống kê (3.1) | [Lab 5 bài 3](../lab5/buoi5/bai3.php), [bài 8](../lab5/buoi5/bai8.php) | JOIN, SUM/COUNT, GROUP BY, HAVING, ORDER BY. |
| Cao nhất từng nhóm (3.2) | [Lab 5 bài 5](../lab5/buoi5/bai5.php), [bài 9](../lab5/buoi5/bai9.php), [bài 12](../lab5/buoi5/bai12.php) | Ghép tổng hợp với subquery MAX; không dùng LIMIT 1 cho toàn bảng vì cần cao nhất **từng nhóm** và giữ đồng hạng. |
| Bảo mật/kiểm tra trùng (3.3) | [Lab 1 xuất HTML](../lab1/bai10/info_process.php), [Lab 4 PDO](../lab4/bai1/add_student.php), [Lab 3 kiểm tra tài khoản](../lab3/bai12/register.php) | Đề 01 phân biệt SQL injection và XSS; đề 02 SELECT kiểm tra tồn tại trước INSERT. Ví dụ Lab 3 dùng mysqli, bài giải chuyển nguyên tắc sang PDO. |

## Thứ tự ôn gợi ý trong 180 phút

Làm 1.1 → 1.2 → 1.3 trước để lấy phần cơ bản không phụ thuộc DB. Import SQL, kiểm tra kết nối rồi làm 1.4. Tiếp theo 2.1, 3.1, 3.2, cuối cùng 3.3 và thử đầu vào sai. Ôn bằng cách đọc bài lab ở cột tham chiếu, tự viết lại câu đề rồi đối chiếu kết quả trong README từng đề.

## Trạng thái kiểm tra

Đã chạy Compose lab4 và import hai CSDL ôn tập với dữ liệu đúng đề. PHP/JavaScript đã qua kiểm tra cú pháp. Đã kiểm tra PHP/PDO trên MySQL 8 của Compose bằng CSDL thử riêng: form, escape HTML, OOP, lọc/tìm kiếm, JSON lỗi, thống kê, đồng hạng, nhóm chưa có lượt, loại cancelled và SELECT trước INSERT. CSDL thử đã được xóa; dữ liệu hai CSDL ôn tập giữ nguyên.

JavaScript đã kiểm tra Event/DOM bằng DOM giả lập trong Node: thêm thiết bị, validation học phí, Fetch không có dữ liệu/lỗi HTTP/lỗi mạng, hiển thị an toàn và cảnh báo hết chỗ. Chưa kiểm tra giao diện trực tiếp trong trình duyệt. Server PHP chưa được khởi chạy thường trực; dùng lệnh ở phần “Chạy bài”.
