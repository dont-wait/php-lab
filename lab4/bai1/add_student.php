<?php

require __DIR__.'/connect.php';
require __DIR__.'/student_helpers.php';
$inserted = false;
$errors = [];
$student = ['name' => '', 'email' => '', 'phone' => '', 'birthday' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student = studentInput();
    $errors = studentErrors($student);
    if (!$errors) {
        try {
            $stmt = $conn->prepare('INSERT INTO students(name, email, phone, birthday) VALUES (?, ?, ?, ?)');
            $stmt->execute([$student['name'], $student['email'], $student['phone'], $student['birthday'] ?: null]);
            $inserted = true;
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
<h1 class="h3 mb-3">Thêm sinh viên</h1>
<?php if ($inserted) { ?>
    <div class="alert alert-success">Thêm sinh viên thành công!</div>
    <a href="list_students.php" class="btn btn-secondary">Quay lại danh sách</a>
<?php } else {
    $submitLabel = 'Thêm sinh viên';
    require __DIR__.'/student_form.php';
} ?>
<?php require __DIR__.'/footer.php'; ?>
