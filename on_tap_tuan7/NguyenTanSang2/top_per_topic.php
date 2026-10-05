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
SELECT totals.topic, totals.title, totals.total_confirmed
FROM (
    SELECT w.workshop_id, w.topic, w.title,
           COUNT(r.reg_id) AS total_confirmed
    FROM workshops w
    LEFT JOIN registrations r ON r.workshop_id = w.workshop_id
                             AND r.status = 'confirmed'
    GROUP BY w.workshop_id, w.topic, w.title
) AS totals
WHERE totals.total_confirmed = (
    SELECT MAX(in_group.total_confirmed)
    FROM (
        SELECT w.workshop_id, w.topic, w.title,
           COUNT(r.reg_id) AS total_confirmed
    FROM workshops w
    LEFT JOIN registrations r ON r.workshop_id = w.workshop_id
                             AND r.status = 'confirmed'
    GROUP BY w.workshop_id, w.topic, w.title
    ) AS in_group
    WHERE in_group.topic = totals.topic
)
ORDER BY totals.topic, totals.title
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
    renderTable($rows, ['topic' => 'Chủ đề', 'title' => 'Tên', 'total_confirmed' => 'Lượt confirmed']);
} ?>
</body>
</html>
