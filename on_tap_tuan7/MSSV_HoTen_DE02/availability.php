<?php
// Câu 2.1 — Lab 3 Fetch/JSON + Lab 4 PDO + Lab 5 LEFT JOIN/COUNT/GROUP BY.
// Ref: lab3/bai7/search.php; lab4/bai1/list_students.php; lab5/buoi5/bai12.php.
require __DIR__.'/helpers.php';
$id = filter_var($_GET['workshop_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id === false || $id === null) jsonResponse(['error' => 'workshop_id phải là số nguyên dương.'], 400);
try {
    require __DIR__.'/connect.php';
    // Đặt status trong ON để workshop không có lượt confirmed vẫn xuất hiện.
    // COUNT(r.reg_id) đếm đăng ký; COUNT(*) sẽ đếm cả dòng rỗng của LEFT JOIN.
    $stmt = $conn->prepare("SELECT w.workshop_id, w.title, w.capacity, COUNT(r.reg_id) AS confirmed
        FROM workshops w
        LEFT JOIN registrations r ON r.workshop_id = w.workshop_id AND r.status = 'confirmed'
        WHERE w.workshop_id = :id
        GROUP BY w.workshop_id, w.title, w.capacity");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
    if (!$row) jsonResponse(['error' => 'Workshop không tồn tại.'], 404);
    foreach (['workshop_id', 'capacity', 'confirmed'] as $key) $row[$key] = (int) $row[$key];
    $row['remaining'] = $row['capacity'] - $row['confirmed'];
    jsonResponse($row);
} catch (PDOException $e) {
    jsonResponse(['error' => 'Không thể kiểm tra số chỗ. Kiểm tra cấu hình MySQL.'], 500);
}
