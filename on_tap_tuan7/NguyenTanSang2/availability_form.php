<?php
// Câu 2.1 — Nạp danh sách chọn từ DB, không hardcode ID trong giao diện.
// Ref: lab4/bai1/list_students.php; lab3/bai7/index.js.
require __DIR__.'/helpers.php';
$workshops = [];
$error = '';
try {
    require __DIR__.'/connect.php';
    $workshops = $conn->query('SELECT workshop_id, title FROM workshops ORDER BY workshop_id')->fetchAll();
} catch (PDOException $e) {
    $error = 'Không thể đọc danh sách workshop. Kiểm tra cấu hình MySQL.';
    http_response_code(500);
}
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Câu 2.1 — Số chỗ còn lại</title></head>
<body>
<h1>Câu 2.1 — Số chỗ còn lại</h1>
<p><?= escape($error) ?></p>
<form id="availability-form">
    <label>Workshop <select id="workshop-id" required>
        <option value="">Chọn workshop</option>
        <?php foreach ($workshops as $row) { ?>
            <option value="<?= escape($row['workshop_id']) ?>"><?= escape($row['title']) ?></option>
        <?php } ?>
    </select></label>
    <button>Kiểm tra</button>
</form>
<p id="result" role="status"></p>
<script src="availability.js"></script>
</body>
</html>
