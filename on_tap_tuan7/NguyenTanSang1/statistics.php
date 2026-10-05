<?php
// Câu 3.1 — Lab 5: JOIN + GROUP BY + HAVING; Ref: lab5/buoi5/bai3.php, bai8.php.
// WHERE lọc dòng trước khi nhóm; HAVING lọc tổng sau khi nhóm.
// SQL cũng nằm trong queries.sql để bạn luyện riêng trong phpMyAdmin.
require __DIR__.'/helpers.php';
$rows = [];
$error = '';
try {
    require __DIR__.'/connect.php';
    $sql = <<<'SQL'
SELECT d.category, SUM(bd.quantity) AS total_borrowed,
       SUM(bd.quantity * d.price) AS total_value
FROM devices d
JOIN borrow_details bd ON bd.device_id = d.device_id
GROUP BY d.category
HAVING SUM(bd.quantity) >= 2
ORDER BY total_borrowed DESC, d.category
SQL;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll();
} catch (PDOException $e) {
    http_response_code(500);
    $error = 'Không thể đọc thống kê. Kiểm tra cấu hình và dữ liệu.';
}
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Câu 3.1 — Thống kê</title></head>
<body>
<h1>Câu 3.1 — Thống kê</h1>
<?php if ($error !== '') { ?><p><?= escape($error) ?></p><?php } else {
    renderTable($rows, ['category' => 'Loại', 'total_borrowed' => 'Tổng số lượng mượn', 'total_value' => 'Tổng giá trị']);
} ?>
</body>
</html>
