<?php
// Câu 1.1 — Lab 1: POST, trim, kiểm tra chuỗi rỗng, escape HTML.
// Ref: lab1/bai10/info_process.php; lab1/bai17/uppercase.php.
require __DIR__.'/helpers.php';
$name = inputText($_POST, 'full_name');
$email = inputText($_POST, 'email');
$errors = [];
$isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
if ($isPost) {
    if ($name === '') $errors[] = 'Họ tên không được rỗng.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ.';
}
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Câu 1.1 — Form họ tên và email</title></head>
<body>
<h1>Câu 1.1 — Form họ tên và email</h1>
<form method="post">
    <label>Họ tên <input name="full_name" value="<?= escape($name) ?>" required></label>
    <label>Email <input name="email" type="email" value="<?= escape($email) ?>" required></label>
    <button>Gửi</button>
</form>
<?php foreach ($errors as $error) { ?><p><?= escape($error) ?></p><?php } ?>
<?php if ($isPost && !$errors) { ?>
    <p>Họ tên: <?= escape($name) ?></p>
    <p>Email: <?= escape($email) ?></p>
<?php } ?>
</body>
</html>
