<?php
// Câu 1.4 — Lab 4: PDO, lọc GET và Prepared Statement.
// Ref: lab4/bai1/list_students.php; lab4/bai1/connect.php.
require __DIR__.'/helpers.php';
$filter = inputText($_GET, 'category');
$rows = [];
$error = '';
try {
    require __DIR__.'/connect.php';
    $sql = 'SELECT device_id, device_name, category, price, stock FROM devices';
    $params = [];
    if ($filter !== '') {
        $sql .= ' WHERE category = :filter';
        $params['filter'] = $filter;
    }
    $stmt = $conn->prepare($sql.' ORDER BY device_id');
    $stmt->execute($params);
    $rows = $stmt->fetchAll();
} catch (PDOException $e) {
    http_response_code(500);
    $error = 'Không thể đọc dữ liệu. Kiểm tra config.php và import database.sql.';
}
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Câu 1.4 — Danh sách</title></head>
<body>
<h1>Câu 1.4 — Danh sách</h1>
<form method="get">
    <label>Loại <input name="category" value="<?= escape($filter) ?>"></label>
    <button>Lọc</button> <a href="list_devices.php">Tất cả</a>
</form>
<?php if ($error !== '') { ?><p><?= escape($error) ?></p><?php } else {
    renderTable($rows, ['device_id' => 'ID', 'device_name' => 'Tên thiết bị', 'category' => 'Loại', 'price' => 'Đơn giá', 'stock' => 'Tồn kho']);
} ?>
</body>
</html>
