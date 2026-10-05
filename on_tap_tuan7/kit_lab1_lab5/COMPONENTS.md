# Kit component PHP — import và sử dụng

Kit dùng PHP **8.1 trở lên**, extension `pdo_mysql`, `mbstring`, `fileinfo`; test độc lập còn dùng `pdo_sqlite`. Không cần Composer hay CDN. Hàm nằm trong namespace `LabKit` để không trùng tên helper của bài làm.

## Đủ các phần trong bộ kit

| Phần | File | Liên hệ lab |
| --- | --- | --- |
| 1. Kết nối MySQL/PDO dùng chung | [connect.php](components/connect.php), [config.php](config.php) | Lab 4, Lab 5 |
| 2. Query layer Prepared Statement | [query.php](components/query.php) | Lab 4 |
| 3. Request/response helper | [request.php](components/request.php), [response.php](components/response.php) | Lab 1, Lab 3 |
| 4. Validation | [validation.php](components/validation.php) | Lab 1, Lab 4 |
| 5. CSRF/security | [security.php](components/security.php) | Escape từ Lab 1/4; CSRF là phần bổ sung |
| 6. Form GET/POST | [form.php](components/form.php) | Lab 1, Lab 4 |
| 7. Table | [table.php](components/table.php) | Lab 1 bài 18, Lab 4/5 |
| 8. Pagination/search/sort | [pagination.php](components/pagination.php), [query.php](components/query.php), [demo](demos/query.php) | Lab 4 |
| 9. Session/auth/cookie | [auth.php](components/auth.php) | Lab 1 bài 13/14/20 |
| 10. File storage | [storage.php](components/storage.php) | Lab 1 bài 12/19, Lab 3 bài 10 |
| 11. Upload | [upload.php](components/upload.php) | Lab 1 bài 11/15; kit thêm MIME/size/tên random |
| 12. JSON/API response | [response.php](components/response.php), [API](demos/api.php) | Lab 3; ghép PDO Lab 4 |
| 13. Demo độc lập | [mục lục demo](demos/index.php) | Ghép component theo từng chức năng |
| 14. Tài liệu import/sử dụng | File này; [bản đồ ôn Lab 1–5](README.md) | Toàn bộ Lab 1–5 |

Các query thống kê Lab 5 vẫn là SQL do bạn viết theo yêu cầu. Kit cung cấp query/table để chạy và hiển thị SQL đó; ví dụ đầy đủ nằm trong [tài liệu Lab 5](lab5.md).

## Chạy demo ngay trên server hiện có

Server đang phục vụ `on_tap_tuan7` ở cổng 8000: mở

`http://localhost:8000/kit_lab1_lab5/demos/index.php`

Hoặc chạy kit độc lập từ gốc repo:

```sh
php -S 127.0.0.1:8002 -t on_tap_tuan7/kit_lab1_lab5/demos
```

Mở `http://127.0.0.1:8002/index.php`. Mỗi demo có link về mục lục.

| Demo | Thử gì? | Có cần MySQL? |
| --- | --- | --- |
| [form.php](demos/form.php) | Họ tên/email; dữ liệu sai; CSRF; xuất dữ liệu an toàn | Không |
| [table.php](demos/table.php) | Bảng thường, bảng rỗng, chuỗi script hiển thị như chữ | Không |
| [query.php](demos/query.php) | Tìm tên, chọn cột sắp xếp, 3 dòng/trang, giữ filter khi đổi trang | Có |
| [api_demo.php](demos/api_demo.php) | GET tìm thiết bị; POST JSON tên với CSRF header | GET cần, POST không |
| [auth.php](demos/auth.php) | Đăng nhập `demo / 123456`, cookie tên, đăng xuất | Không |
| [storage.php](demos/storage.php) | Ghi nối ghi chú, lưu metadata JSON, đọc lại | Không |
| [upload.php](demos/upload.php) | PNG/JPEG/PDF, MIME thật, dung lượng, tải lại file | Không |

PDO mặc định dùng `week7_device`, root/sa123 theo Compose lab4. CSDL này đã được tạo trong phiên làm bài ôn. Khi chuyển máy, sửa `config.php`; nếu chưa có CSDL thì import [database.sql](database.sql) bằng phpMyAdmin. **Không import lại khi bảng đã tồn tại.** Kit không tạo/sửa CSDL khi chạy bootstrap; demo query và GET API chỉ đọc.

File text/JSON/upload mặc định ở thư mục `php-lab-kit` trong thư mục tạm của hệ điều hành, ngoài web root. Có thể đổi `storage` sang thư mục riêng có quyền ghi để lưu lâu dài. Dữ liệu demo file dùng chung trên máy, không phân theo tài khoản.

## Import vào bài mới

Chép `bootstrap.php`, `config.php` và thư mục `components` vào thư mục `kit` trong bài mới. Demo, test và tài liệu không cần thiết cho ứng dụng sử dụng kit.

```php
<?php
// Nạp trước mọi HTML: bootstrap mở session cho auth/CSRF.
require_once __DIR__.'/kit/bootstrap.php';
use function LabKit\{db, text, rows, table, containsPattern};

$keyword = text($_GET, 'keyword');
$data = rows(db(), "SELECT device_id, device_name FROM devices
    WHERE device_name LIKE :keyword ESCAPE '!'",
    ['keyword' => containsPattern($keyword)]);
table($data, ['device_id' => 'ID', 'device_name' => 'Tên']);
```

Đổi `database.name` trong config theo schema bài mới. Tên bảng/cột trong SQL phải theo schema đó. `db()` chỉ kết nối khi được gọi, nên các demo không dùng DB vẫn chạy khi MySQL tắt.

## Công thức ghép component

**Form POST:** `requirePostCsrf()` → `text($_POST, ...)` → `validate()` → xử lý khi không có lỗi → `form()`/`table()`. Form POST do helper tạo tự có input `_csrf`. Lỗi validation là mảng `tên_field => thông báo` để form hiển thị bên field.

```php
$values = ['email' => LabKit\text($_POST, 'email')];
$errors = [];
if (LabKit\isPost()) {
    LabKit\requirePostCsrf();
    $errors = LabKit\validate($values, [
        'email' => ['label' => 'Email', 'required' => true, 'email' => true, 'maxLength' => 120],
    ]);
}
LabKit\form('form.php', 'POST', [
    'email' => ['label' => 'Email', 'type' => 'email', 'required' => true],
], $values, $errors);
```

Validation hỗ trợ `required`, `email`, `number`, `integer`, `min`, `max`, `maxLength`. Min/max áp dụng khi dùng rule number hoặc integer. Giá trị rỗng của field không required được bỏ qua. Input dạng mảng bị từ chối; số 0 hợp lệ nếu min cho phép. Rule browser trong form chỉ hỗ trợ UX, vẫn phải validation ở PHP.

**Query:** `query()` trả PDOStatement; `rows()` trả nhiều dòng; `row()` trả một dòng hoặc null; `scalar()` trả một ô. Các hàm nhận PDO để có thể dùng nhiều kết nối hoặc test với SQLite. Query layer không kiểm tra business rule và không tự làm an toàn nếu bạn nối input trực tiếp vào SQL.

```php
// Giá trị do người dùng nhập luôn bind, không nối vào câu SQL.
$item = LabKit\row(LabKit\db(), 'SELECT * FROM devices WHERE device_id = :id', ['id' => 1]);
// INSERT/UPDATE/DELETE dùng query(..., $params) tương tự; validate và CSRF trước.
```

**Search/sort/pagination:** lấy tên cột từ `allowedIdentifier()` với allowlist cố định trong code. COUNT và SELECT dùng cùng WHERE/params. `pagination()` giới hạn page trong khoảng hợp lệ; `query()` bind limit/offset là int. `paginationLinks()` giữ filters và thay page. Xem demo query đầy đủ.

**API JSON:** `json($data, $status)` đặt Content-Type/mã HTTP rồi dừng PHP. Không echo thông báo trước khi gọi. Với POST JSON, đọc bằng `jsonBody()` và gửi CSRF token trong `X-CSRF-Token`; xác minh bằng `verifyCsrf()`. `requirePostCsrf()` dùng cho POST form, không đọc JSON body. Ví dụ cả hai nằm ở demo form/API.

**Auth/cookie:** kiểm tra password trước khi gọi `login($user)`; `currentUser()` đọc user từ session; `requireLogin()` trả user hoặc HTTP 401; `logout()` xóa user và đổi session ID. `remember()`/`forget()` xử lý cookie tùy chọn. Cookie tên trong demo không xác thực người dùng. Tài khoản cố định trong demo chỉ để luyện; ứng dụng thật dùng password hash từ DB.

**Storage/upload:** `writeText($key, $text, $append)`, `readText($key)`, `writeJson($key, $data)`, `readJson($key)`. Chỉ nhận tên file đơn, chặn `../` và symlink. Ghi dùng LOCK_EX; chu trình đọc → sửa → ghi JSON chưa phải giao dịch đồng thời. Upload kiểm tra file HTTP, size thực, MIME; đặt tên random, không dùng tên người gửi làm đường dẫn. Download demo chỉ nhận key upload và trả attachment. Không ghi đè file PHP trong web root.

## Kiểm tra kit

Từ gốc repo:

```sh
php on_tap_tuan7/kit_lab1_lab5/tests/run.php
```

29 kiểm tra độc lập: input/validation, escape, CSRF, PDO/placeholder trên SQLite bộ nhớ, allowlist, phân trang, form/table, login/logout, file text/JSON và từ chối upload lỗi. Test chỉ xóa file thử có tên random do chính nó tạo.

Đã kiểm tra riêng 28 trường hợp HTTP trên PHP server hiện có: demo, MySQL thật, tìm tiếng Việt, SQL injection, form/JSON, CSRF, session, upload PNG thật và download đối chiếu bytes, chặn file PHP/path traversal. JavaScript đã kiểm tra cú pháp; chưa kiểm tra thao tác giao diện trực tiếp trong trình duyệt.
