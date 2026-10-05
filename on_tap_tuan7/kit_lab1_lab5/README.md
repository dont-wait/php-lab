# Bộ kit ôn tập Lab 1–5

Kit gồm component PHP tái sử dụng, demo chạy độc lập, bản đồ bài tập, mẫu code có comment, lỗi dễ gặp và bài tự luyện. Nội dung đối chiếu với file lab đang có trong repo. Mẫu trong tài liệu là khung để tự viết lại; các file lab và hai đề là ví dụ ứng dụng cụ thể.

| Muốn làm gì? | Mở tài liệu | Câu trong hai đề |
| --- | --- | --- |
| PHP cơ bản, form, file, session, cookie | [Lab 1](lab1.md) | 1.1; bảo mật HTML trong 3.3 đề 01 |
| Class, constructor, đóng gói, kế thừa, interface | [Lab 2](lab2.md) | 1.2 |
| DOM/Event, Fetch, JSON | [Lab 3](lab3.md) | 1.3; phần giao tiếp của 2.1; kiểm tra trùng 3.3 đề 02 |
| PDO, CRUD, tìm kiếm, phân trang | [Lab 4](lab4.md) | 1.4; phần truy vấn của 2.1; Prepared Statement |
| JOIN, GROUP BY, HAVING, subquery | [Lab 5](lab5.md) | 3.1, 3.2; đếm chỗ trong 2.1 đề 02 |

**Mẹo nhận dạng:** thấy form → Lab 1; thấy class → Lab 2; thấy không tải lại trang → Lab 3; thấy đọc/ghi CSDL → Lab 4; thấy tổng/theo nhóm/cao nhất → Lab 5. Một câu có thể ghép nhiều lab.

## Component và demo chạy được

- [Hướng dẫn import/sử dụng và danh sách 14 phần](COMPONENTS.md).
- [Mã component](components/connect.php), nạp qua [bootstrap.php](bootstrap.php).
- [Mục lục demo](demos/index.php): mở `http://localhost:8000/kit_lab1_lab5/demos/index.php`.
- [Kiểm tra component](tests/run.php): chạy `php on_tap_tuan7/kit_lab1_lab5/tests/run.php`.

## Hai bài ôn để đối chiếu

- [Đề 01](../NguyenTanSang1/README.md): thiết bị, tìm kiếm, thống kê lượt mượn.
- [Đề 02](../NguyenTanSang2/README.md): workshop, kiểm tra số chỗ, thống kê confirmed.
- [Hướng dẫn chung](../README.md): cách chạy và bản đồ câu hỏi.

## Cách dùng kit

1. Đọc bảng bài tập của lab để tìm ví dụ gốc.
2. Viết lại mẫu bằng dữ liệu của mình; chỉ đổi tên biến, bảng và điều kiện khi hiểu mục đích.
3. Làm bài tự luyện cuối mỗi tài liệu rồi đối chiếu kết quả.
4. Khi ôn hai đề, ghép mẫu đúng lab thay vì học thuộc cả trang dài.

Đường dẫn file trong tài liệu mở mã nguồn. Để chạy lab gốc, từ gốc repo dùng `php -S 127.0.0.1:8001 -t .`, rồi mở `/lab1/...`, `/lab2/...` hoặc `/lab3/...`. Các bài có CSDL cần import schema và kiểm tra cấu hình của chính lab đó. Lab 3 bài 11 dùng API bên ngoài; những bài còn lại nêu trong kit có thể ôn bằng dữ liệu cục bộ.
