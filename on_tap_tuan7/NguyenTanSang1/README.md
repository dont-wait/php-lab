# Quản lý mượn thiết bị

CSDL `week7_device`. Xem [cách chạy chung](../README.md#chạy-bài); mở `index.html` qua localhost để chọn câu.

## Câu hỏi, bài giải và lab liên quan

| Câu | File bài giải | Tham chiếu lab | Kiến thức và cách áp dụng |
| --- | --- | --- | --- |
| 1.1 | [student_form.php](student_form.php) | [Lab 1 bài 10](../../lab1/bai10/info_process.php), [bài 17](../../lab1/bai17/uppercase.php) | POST họ tên/email; `trim`; tên không rỗng; `FILTER_VALIDATE_EMAIL`; chỉ hiển thị kết quả hợp lệ, dùng `htmlspecialchars` qua `escape()`. |
| 1.2 | [Device.php](Device.php), [device_demo.php](device_demo.php) | [Lab 2 bài 2](../../lab2/bai2.php), [bài 6](../../lab2/bai6/BankAccount.php), [bài 7](../../lab2/bai7/Book.php) | Thuộc tính private, constructor, getter; `getInventoryValue() = price × stock`; `showInfo()` xuất đủ 4 thông tin. |
| 1.3 | [select_device.html](select_device.html), [JS](select_device.js) | [Lab 3 bài 2](../../lab3/bai2/index.js) | Event submit, ngăn tải lại, trim tên, tạo li, thêm vào ul rồi xóa input. `textContent` giữ tên là văn bản. |
| 1.4 | [list_devices.php](list_devices.php) | [Lab 4 danh sách](../../lab4/bai1/list_students.php), [PDO](../../lab4/bai1/connect.php) | Category từ GET, có giá trị thì thêm `WHERE category = :filter`; execute truyền giá trị; xuất đủ 5 cột an toàn. |
| 2.1 | [search_device.html](search_device.html), [JS](search_device.js), [search_device.php](search_device.php) | [Lab 3 Fetch](../../lab3/bai7/index.js), [JSON](../../lab3/bai7/search.php), [Lab 4 LIKE/PDO](../../lab4/bai1/list_students.php) | Ghép mới: Fetch gửi keyword/max_price → PDO lọc → JSON → DOM. Chỉ thêm điều kiện giá nếu có nhập; xử lý rỗng, HTTP lỗi và lỗi mạng. |
| 3.1 | [statistics.php](statistics.php), [queries.sql](queries.sql) | [Lab 5 bài 8](../../lab5/buoi5/bai8.php), [bài 3](../../lab5/buoi5/bai3.php) | JOIN thiết bị với chi tiết mượn, tổng quantity và quantity × price; nhóm category, HAVING tổng ≥ 2, sắp xếp giảm dần. |
| 3.2 | [top_per_category.php](top_per_category.php), [queries.sql](queries.sql) | [Lab 5 MAX từng nhóm](../../lab5/buoi5/bai5.php), [tổng đã bán](../../lab5/buoi5/bai9.php), [LEFT JOIN](../../lab5/buoi5/bai12.php) | Tính tổng từng thiết bị trong bảng con; so với MAX tổng của cùng category. Dùng dấu `=` để giữ đồng hạng. |
| 3.3 | [security.html](security.html) | [Lab 4 Prepared Statement](../../lab4/bai1/list_students.php), [Lab 1 escape HTML](../../lab1/bai10/info_process.php) | Đáp án 5 dòng: mục đích của hai kỹ thuật và vị trí sử dụng trong bài. |

## Kết quả mẫu để tự kiểm tra

- 1.1: họ tên chỉ có khoảng trắng hoặc email `abc` phải báo lỗi. Tên `<script>alert(1)</script>` với email hợp lệ phải hiển thị như chữ, không chạy script.
- 1.2: Laptop Dell Latitude, giá 18.500.000, stock 8 → tổng giá trị tồn **148.000.000**.
- 1.3: thêm `Webcam` → có li mới và input rỗng. Chuỗi chỉ có khoảng trắng không được thêm.
- 1.4: `?category=Laptop` → 2 dòng; không nhập category → 6 dòng.
- 2.1: keyword `Laptop`, max_price `18000000` → chỉ Laptop HP ProBook. Keyword rỗng, giá rỗng → 6 dòng. Giá `0` → không có dữ liệu. Giá âm/không phải số → HTTP 400; lỗi CSDL → JSON lỗi HTTP 500. `%` và `_` trong keyword được tìm như ký tự thông thường.

Câu 3.1:

| category | total_borrowed | total_value |
| --- | ---: | ---: |
| Phụ kiện | 5 | 12.850.000 |
| Laptop | 3 | 54.200.000 |
| Màn hình | 2 | 7.800.000 |

Trình chiếu chỉ có 1 lượt nên bị HAVING loại ra. `SUM(quantity)` là số thiết bị đã mượn; `COUNT(*)` chỉ đếm dòng chi tiết và cho kết quả sai ở bài này.

Câu 3.2:

| category | device_name | total_borrowed |
| --- | --- | ---: |
| Laptop | Laptop Dell Latitude | 2 |
| Màn hình | Màn hình 24 inch | 2 |
| Phụ kiện | Webcam Logitech | 3 |
| Trình chiếu | Máy chiếu Epson | 1 |

Truy vấn dùng LEFT JOIN và COALESCE để thiết bị chưa từng được mượn có tổng 0. Nếu một loại chưa có lượt mượn nào, mọi thiết bị thuộc loại đó đồng hạng 0. Nếu tăng lượt HP lên 2, kết quả Laptop phải có cả Dell lẫn HP. Không trừ tồn kho hoặc tạo phiếu mượn vì đề chỉ yêu cầu đọc dữ liệu.
