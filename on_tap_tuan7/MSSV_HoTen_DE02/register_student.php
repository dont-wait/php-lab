<?php
// Câu 3.3 — Kiểm tra tồn tại trước INSERT bằng Prepared Statement.
// Ref: lab3/bai12/register.php (SELECT rồi INSERT, ví dụ mysqli);
//      lab4/bai1/add_student.php (Prepared Statement với PDO).
require __DIR__.'/helpers.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = filter_var($_POST['student_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $workshopId = filter_var($_POST['workshop_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if (!$studentId || !$workshopId) {
        $message = 'Hai ID phải là số nguyên dương.';
    } else {
        try {
            require __DIR__.'/connect.php';
            $stmt = $conn->prepare('SELECT reg_id FROM registrations WHERE student_id = :student_id AND workshop_id = :workshop_id LIMIT 1');
            $params = ['student_id' => $studentId, 'workshop_id' => $workshopId];
            $stmt->execute($params);
            // Đề nói "đã có bản ghi": kể cả cancelled cũng không thêm lại.
            if ($stmt->fetch()) {
                $message = 'Sinh viên đã đăng ký workshop này; không thêm mới.';
            } else {
                $stmt = $conn->prepare("INSERT INTO registrations (student_id, workshop_id, registered_at, status)
                    VALUES (:student_id, :workshop_id, CURRENT_DATE, 'confirmed')");
                $stmt->execute($params);
                $message = 'Đăng ký thành công.';
            }
        } catch (PDOException $e) {
            $message = 'Không thể đăng ký. Kiểm tra hai ID có tồn tại và cấu hình MySQL.';
        }
    }
}
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Câu 3.3 — Kiểm tra đăng ký trùng</title></head>
<body>
<h1>Câu 3.3 — Kiểm tra đăng ký trùng</h1>
<form method="post">
    <label>student_id <input name="student_id" type="number" min="1" required></label>
    <label>workshop_id <input name="workshop_id" type="number" min="1" required></label>
    <button>Đăng ký</button>
</form>
<p><?= escape($message) ?></p>
</body>
</html>
