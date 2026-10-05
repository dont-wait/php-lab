# Lab 1 — PHP cơ bản và xử lý dữ liệu

Ứng dụng trong đề: **câu 1.1** và phần `htmlspecialchars()` của **3.3 đề 01**.

## Bài gốc nên xem

| Bài | File | Kiến thức |
| --- | --- | --- |
| 1–2 | [bài 1](../../lab1/bai1.php), [bài 2](../../lab1/bai2.php) | echo, biến, nối chuỗi, ngày giờ |
| 3–4 | [bán kính GET](../../lab1/bai3/circle.php), [xếp loại POST](../../lab1/bai4/grade.php) | GET/POST, số và điều kiện |
| 5–9 | [bài 5](../../lab1/bai5.php), [6](../../lab1/bai6.php), [7](../../lab1/bai7.php), [8](../../lab1/bai8.php), [9](../../lab1/bai9.php) | Vòng lặp, số nguyên tố, hàm, mảng min/max, chuỗi |
| 10 | [info_process.php](../../lab1/bai10/info_process.php) | Nhận form và xuất HTML |
| 11 | [upload.php](../../lab1/bai11/upload.php) | $_FILES, move_uploaded_file |
| 12 | [save.php](../../lab1/bai12/save.php) | Ghi nối file, FILE_APPEND, LOCK_EX |
| 13 | [login.php](../../lab1/bai13/login.php), [welcome.php](../../lab1/bai13/welcome.php), [logout.php](../../lab1/bai13/logout.php) | Session đăng nhập |
| 14 | [remember.php](../../lab1/bai14/remember.php) | Cookie ghi nhớ |
| 15 | [login.php](../../lab1/bai15/login.php), [upload.php](../../lab1/bai15/upload.php), [files.php](../../lab1/bai15/files.php) | Ghép session với upload/danh sách file |
| 16–18 | [tổng 1..N](../../lab1/bai16/sum.php), [viết hoa](../../lab1/bai17/uppercase.php), [sinh viên](../../lab1/bai18/students.php) | Validation, hàm, mảng nhiều chiều |
| 19–20 | [ghi chú](../../lab1/bai19/save.php), [lưu tên](../../lab1/bai20/save_name.php) | Đọc/ghi file, cookie và chuyển hướng |

## Mẫu 1: form POST tự xử lý

Lưu thành `form.php`, mở qua PHP server. Mẫu tương ứng bài 10 + bài 17; kiểm tra email là phần bổ sung theo đề.

```php
<?php
// $_POST chỉ có dữ liệu khi trình duyệt gửi form bằng POST.
$name = is_string($_POST['name'] ?? null) ? trim($_POST['name']) : '';
$email = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
$errors = [];
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
if ($isPost) {
    if ($name === '') $errors[] = 'Tên không được rỗng.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ.';
}
function escape($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<meta charset="utf-8">
<form method="post">
    <input name="name" value="<?= escape($name) ?>" placeholder="Họ tên">
    <input name="email" value="<?= escape($email) ?>" placeholder="Email">
    <button>Gửi</button>
</form>
<?php foreach ($errors as $error) { ?><p><?= escape($error) ?></p><?php } ?>
<?php if ($isPost && !$errors) { ?>
    <p><?= escape($name) ?> — <?= escape($email) ?></p>
<?php } ?>
```

Đọc input → kiểm tra → xử lý → escape lúc hiển thị. Không dùng escape để thay cho validation hoặc Prepared Statement. `name` trong input phải khớp key PHP; `id` chỉ giúp JavaScript/label nhận diện.

## Mẫu 2: nhận số nguyên và tính tổng

Ref bài 16. Dùng so sánh `=== false`, vì số 0 và giá trị false có ý nghĩa khác nhau.

```php
<?php
$n = filter_var($_GET['n'] ?? null, FILTER_VALIDATE_INT);
if ($n === false || $n === null || $n < 1) {
    echo 'N phải là số nguyên dương.';
    exit;
}
$total = 0;
for ($i = 1; $i <= $n; $i++) $total += $i;
echo $total;
```

## Mẫu 3: session, cookie, file

Ba đoạn độc lập, không ghép ngay thành một file. Ref bài 13, 20, 19.

```php
<?php
// Session: gọi trước khi xuất HTML. Chỉ gán user sau khi kiểm tra đăng nhập.
session_start();
$_SESSION['user'] = 'Sang';
echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8');
```

```php
<?php
// Cookie: browser gửi lại ở request sau; phải set trước khi xuất HTML.
setcookie('remembered_name', 'Sang', time() + 3600, '/');
// Đọc: $_COOKIE['remembered_name'] ?? ''
// Xóa: setcookie('remembered_name', '', time() - 3600, '/');
```

```php
<?php
// __DIR__ giữ đường dẫn theo vị trí file PHP, không theo thư mục chạy lệnh.
$file = __DIR__.'/note.txt';
$written = file_put_contents($file, "Ôn Lab 1\n", FILE_APPEND | LOCK_EX);
if ($written === false) { echo 'Không ghi được file.'; exit; }
echo '<pre>'.htmlspecialchars(file_get_contents($file), ENT_QUOTES, 'UTF-8').'</pre>';
```

Upload cần `<form method="post" enctype="multipart/form-data">`, `<input type="file" name="avatar">`, đọc `$_FILES['avatar']`, kiểm tra `error` rồi `move_uploaded_file`. Xem bài 11 để luyện luồng này; kiểm tra extension trong lab là ví dụ cơ bản, không phải kiểm tra nội dung file đầy đủ.

## Lỗi dễ gặp và tự luyện

- `empty('0')` là true; nếu 0 được chấp nhận, kiểm tra chuỗi `=== ''`.
- Ép `(float) 'abc'` ra 0 không chứng minh input là số; dùng `is_numeric`/`filter_var` trước.
- `header`, `setcookie`, `session_start` phải thực hiện trước nội dung HTML.
- `htmlspecialchars` bảo vệ ngữ cảnh HTML, không bảo vệ truy vấn SQL.

Tự luyện: tên chỉ có khoảng trắng phải bị từ chối; email `abc` phải báo sai; `<script>alert(1)</script>` phải hiện như chữ. Với N = 5, tổng phải là 15. Ghi ghi chú hai lần phải có hai dòng, không mất dòng cũ.
