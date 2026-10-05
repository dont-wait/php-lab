<?php
// Câu 3.2 — Lab 5: Subquery + MAX + tổng hợp; Ref: lab5/buoi5/bai5.php, bai9.php, bai12.php.
// Tính tổng trước, so với MAX của cùng nhóm; dùng = để giữ mọi đồng hạng.
// SQL cũng nằm trong queries.sql để bạn luyện riêng trong phpMyAdmin.
require __DIR__.'/helpers.php';
$rows = [];
$error = '';
try {
    require __DIR__.'/connect.php';
    $sql = <<<'SQL'
SELECT totals.category, totals.device_name, totals.total_borrowed
FROM (
    SELECT d.device_id, d.category, d.device_name,
           COALESCE(SUM(bd.quantity), 0) AS total_borrowed
    FROM devices d
    LEFT JOIN borrow_details bd ON bd.device_id = d.device_id
    GROUP BY d.device_id, d.category, d.device_name
) AS totals
WHERE totals.total_borrowed = (
    SELECT MAX(in_group.total_borrowed)
    FROM (
        SELECT d.device_id, d.category, d.device_name,
           COALESCE(SUM(bd.quantity), 0) AS total_borrowed
    FROM devices d
    LEFT JOIN borrow_details bd ON bd.device_id = d.device_id
    GROUP BY d.device_id, d.category, d.device_name
    ) AS in_group
    WHERE in_group.category = totals.category
)
ORDER BY totals.category, totals.device_name
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
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Câu 3.2 — Thống kê</title></head>
<body>
<h1>Câu 3.2 — Thống kê</h1>
<?php if ($error !== '') { ?><p><?= escape($error) ?></p><?php } else {
    renderTable($rows, ['category' => 'Loại', 'device_name' => 'Tên', 'total_borrowed' => 'Tổng lượt mượn']);
} ?>
</body>
</html>
