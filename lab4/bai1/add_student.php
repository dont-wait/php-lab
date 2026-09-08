<?php

require 'connect.php';
$inserted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare('INSERT INTO students(name, email, phone) VALUES (?, ?, ?)');
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone']]);
    $inserted = true;
}

require __DIR__ . '/header.php';
?>
<?php if ($inserted) { ?>
    <div class="m-4">
        <div class="alert alert-success">
            Thêm sinh viên thành công!
        </div>

        <a href="list_students.php" class="btn btn-secondary">
            Quay lại danh sách
        </a>
    </div>
<?php } else { ?>
    <form method="post" class="p-4 border rounded shadow-sm">

        <div class="mb-3">
            <label for="name" class="form-label">Họ tên</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" id="phone" name="phone" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            Thêm sinh viên
        </button>

        <a href="list_students.php" class="btn btn-secondary">
            Quay lại danh sách
        </a>

    </form>
<?php } ?>

<?php require __DIR__ . '/footer.php'; ?>
