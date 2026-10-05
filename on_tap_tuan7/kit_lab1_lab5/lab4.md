# Lab 4 — PDO, CRUD, tìm kiếm và phân trang

Ứng dụng trong đề: **1.4**, phần truy vấn của **2.1**, Prepared Statement của **3.3**.

## Bài gốc nên xem

Lab 4 dùng chung ứng dụng sinh viên trong `bai1`; các yêu cầu tìm kiếm/phân trang/sắp xếp được ghép vào ứng dụng, không tách thành file `bai7.php` riêng.

| Chức năng | File | Cần ôn |
| --- | --- | --- |
| Schema | [database.sql](../../lab4/sql/database.sql) | Bảng students, khóa chính và dữ liệu mẫu |
| Kết nối | [connect.php](../../lab4/bai1/connect.php) | PDO, DSN, charset, ERRMODE_EXCEPTION |
| Danh sách | [list_students.php](../../lab4/bai1/list_students.php) | LIKE, lọc GET, COUNT, phân trang, sắp xếp |
| Thêm | [add_student.php](../../lab4/bai1/add_student.php) | Prepared INSERT, validation, email trùng |
| Sửa | [edit_student.php](../../lab4/bai1/edit_student.php) | SELECT theo ID rồi UPDATE |
| Xóa | [delete_student.php](../../lab4/bai1/delete_student.php) | Prepared DELETE và chuyển hướng |
| Hàm chung | [student_helpers.php](../../lab4/bai1/student_helpers.php) | Đọc input, validation, escape |
| Giao diện dùng chung | [student_form.php](../../lab4/bai1/student_form.php), [header.php](../../lab4/bai1/header.php), [footer.php](../../lab4/bai1/footer.php) | require và tái sử dụng form |
| Các yêu cầu 7–11 | [README Lab 4](../../lab4/README.md) | Tìm kiếm, phân trang, birthday, Prepared Statement, allowlist sắp xếp |

## Mẫu kết nối

Ref `connect.php`. Mẫu dưới dùng CSDL đề 01 đã tạo; nếu luyện trên Lab 4 thì đổi dbname thành `lab4_nts` sau khi import schema tương ứng.

```php
<?php
$conn = new PDO(
    'mysql:host=127.0.0.1;port=3306;dbname=week7_device;charset=utf8mb4',
    'root', 'sa123',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     PDO::ATTR_EMULATE_PREPARES => false]
);
```

`charset=utf8mb4` thiết lập mã hóa kết nối PHP. Khi import SQL bằng client, dùng `SET NAMES utf8mb4;` hoặc tùy chọn `--default-character-set=utf8mb4` để dữ liệu tiếng Việt không bị sai từ đầu.

## Mẫu SELECT có bộ lọc tùy chọn

Ref `list_students.php`; đặt sau kết nối trên. Tên bảng/cột cố định trong SQL, chỉ giá trị đầu vào được truyền qua placeholder.

```php
$category = is_string($_GET['category'] ?? null) ? trim($_GET['category']) : '';
$sql = 'SELECT device_id, device_name, category, price, stock FROM devices';
$params = [];
if ($category !== '') {
    $sql .= ' WHERE category = :category';
    $params['category'] = $category;
}
$stmt = $conn->prepare($sql.' ORDER BY device_id');
$stmt->execute($params);
$rows = $stmt->fetchAll();
foreach ($rows as $row) {
    echo htmlspecialchars($row['device_name'], ENT_QUOTES, 'UTF-8').'<br>';
}
```

`fetch()` lấy một dòng hoặc false; `fetchAll()` lấy mảng các dòng; `fetchColumn()` lấy một giá trị, tiện cho COUNT. `PDO::FETCH_ASSOC` dùng tên cột làm key.

## Mẫu CRUD và kiểm tra tồn tại

Ref add/edit/delete của Lab 4. Các đoạn SQL này dùng **schema lab4_nts** và biến `$conn` trỏ tới CSDL đó. `$name`, `$email`, `$id` phải được lấy/kiểm tra trước khi execute; không chạy mẫu xóa lên dữ liệu đang cần giữ.

```php
// CREATE
$stmt = $conn->prepare('INSERT INTO students(name, email, phone, birthday) VALUES (?, ?, ?, ?)');
$stmt->execute([$name, $email, $phone, $birthday ?: null]);

// READ một dòng
$stmt = $conn->prepare('SELECT * FROM students WHERE id = ?');
$stmt->execute([$id]);
$student = $stmt->fetch();

// UPDATE: WHERE giới hạn đúng đối tượng cần sửa.
$stmt = $conn->prepare('UPDATE students SET name = ?, email = ? WHERE id = ?');
$stmt->execute([$name, $email, $id]);

// DELETE: không bỏ WHERE.
$stmt = $conn->prepare('DELETE FROM students WHERE id = ?');
$stmt->execute([$id]);
```

Câu 3.3 đề 02 ghép nguyên tắc kiểm tra tài khoản tồn tại của Lab 3 bài 12 với PDO của Lab 4:

```php
$stmt = $conn->prepare('SELECT reg_id FROM registrations WHERE student_id = ? AND workshop_id = ? LIMIT 1');
$stmt->execute([$studentId, $workshopId]);
if ($stmt->fetch()) {
    echo 'Đã đăng ký, không thêm.';
} else {
    // Chỉ INSERT khi chưa có bản ghi; mọi giá trị vẫn truyền qua execute.
}
```

Mẫu này dùng `$conn` trỏ tới `week7_workshop`, không phải `lab4_nts`. “Có bản ghi” gồm cả cancelled theo đề.

## Mẫu phân trang và sắp xếp

Ref `list_students.php`; dùng schema `lab4_nts`. Cần đếm tổng dòng theo cùng điều kiện để tính tổng trang; đây là phần truy vấn từng trang.

```php
$limit = 5;
$page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: 1;
$offset = ($page - 1) * $limit;
$keyword = is_string($_GET['keyword'] ?? null) ? trim($_GET['keyword']) : '';
$sort = is_string($_GET['sort'] ?? null) ? $_GET['sort'] : 'id';
$sort = in_array($sort, ['id', 'name', 'email'], true) ? $sort : 'id';
$stmt = $conn->prepare("SELECT * FROM students WHERE name LIKE :keyword ORDER BY $sort ASC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':keyword', '%'.$keyword.'%', PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();
```

Không bind tên cột bằng `ORDER BY :sort`; placeholder đại diện **giá trị**, không đại diện tên bảng/cột. Chọn tên cột từ allowlist cố định. Phần keyword của mẫu này giữ ý nghĩa wildcard `%`/`_` như Lab 4; bài tìm thiết bị có thêm ESCAPE để tìm hai ký tự đó theo nghĩa đen.

## Tự luyện

Dùng DB đề 01: category Laptop → 2 dòng; category không tồn tại → 0 dòng; chuỗi `' OR 1=1 --` không được làm xuất toàn bộ dữ liệu. Giải thích khác nhau giữa Prepared Statement (SQL injection) và htmlspecialchars/textContent (xuất HTML/DOM an toàn).
