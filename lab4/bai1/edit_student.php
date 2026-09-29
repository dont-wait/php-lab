<?php

require __DIR__.'/connect.php';
require __DIR__.'/student_helpers.php';
$updated = false;
$errors = [];
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$stmt = $conn->prepare('SELECT * FROM students WHERE id = ?');
$stmt->execute([$id ?: 0]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$student) {
    http_response_code(404);
    require __DIR__.'/header.php';
    echo '<div class="alert alert-warning">Không tìm thấy sinh viên.</div><a href="list_students.php" class="btn btn-secondary">Quay lại danh sách</a>';
    require __DIR__.'/footer.php';
    exit;
}
$student['birthday'] = $student['birthday'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student = studentInput();
    $errors = studentErrors($student);
    if (!$errors) {
        try {
            $stmt = $conn->prepare('UPDATE students SET name = ?, email = ?, phone = ?, birthday = ? WHERE id = ?');
            $stmt->execute([$student['name'], $student['email'], $student['phone'], $student['birthday'] ?: null, $id]);
            $updated = true;
        } catch (PDOException $e) {
            if (($e->errorInfo[1] ?? null) !== 1062) {
                throw $e;
            }
            $errors[] = 'Email đã tồn tại. Vui lòng nhập email khác.';
        }
    }
}
require __DIR__.'/header.php';
?>
<h1 class="h3 mb-3">Cập nhật sinh viên</h1>
<?php if ($updated) { ?>
    <div class="alert alert-success">Cập nhật sinh viên thành công!</div>
    <a href="list_students.php" class="btn btn-secondary">Quay lại danh sách</a>
<?php } else {
    $submitLabel = 'Cập nhật';
    require __DIR__.'/student_form.php';
} ?>
<?php require __DIR__.'/footer.php'; ?>
