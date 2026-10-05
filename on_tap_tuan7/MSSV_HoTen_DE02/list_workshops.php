<?php
// Câu 1.4 — Lab 4: PDO, lọc GET và Prepared Statement.
// Ref: lab4/bai1/list_students.php; lab4/bai1/connect.php.
require __DIR__.'/helpers.php';
$filter = inputText($_GET, 'topic');
$rows = [];
$error = '';
try {
    require __DIR__.'/connect.php';
    $sql = 'SELECT workshop_id, title, topic, fee, capacity FROM workshops';
    $params = [];
    if ($filter !== '') {
        $sql .= ' WHERE topic = :filter';
        $params['filter'] = $filter;
    }
    $stmt = $conn->prepare($sql.' ORDER BY workshop_id');
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
    <label>Chủ đề <input name="topic" value="<?= escape($filter) ?>"></label>
    <button>Lọc</button> <a href="list_workshops.php">Tất cả</a>
</form>
<?php if ($error !== '') { ?><p><?= escape($error) ?></p><?php } else {
    renderTable($rows, ['workshop_id' => 'ID', 'title' => 'Tên workshop', 'topic' => 'Chủ đề', 'fee' => 'Học phí', 'capacity' => 'Sức chứa']);
} ?>
</body>
</html>
