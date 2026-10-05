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
SELECT w.topic, COUNT(r.reg_id) AS total_confirmed,
       SUM(w.fee) AS total_revenue
FROM workshops w
JOIN registrations r ON r.workshop_id = w.workshop_id
WHERE r.status = 'confirmed'
GROUP BY w.topic
HAVING COUNT(r.reg_id) >= 2
ORDER BY total_confirmed DESC, w.topic
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
    renderTable($rows, ['topic' => 'Chủ đề', 'total_confirmed' => 'Lượt confirmed', 'total_revenue' => 'Doanh thu dự kiến']);
} ?>
</body>
</html>
