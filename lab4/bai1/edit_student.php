<?php
require 'connect.php';

$updated = false;

if (isset($_GET['id'])) {
    $stmt = $conn->prepare('SELECT * FROM students WHERE id=?');
    $stmt->execute([$_GET['id']]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare('UPDATE students SET name=?, email=?, phone=? 
WHERE id=?');
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone'],
        $_POST['id']]);
    $updated = true;
}
?> 
<?php if ($updated) {?>
<div class="m-4">
        <div class="alert alert-success">
            Cập nhật sinh viên thành công!
        </div>

        <a href="list_students.php" class="btn btn-secondary">
            Quay lại danh sách
        </a>
    </div>
<?php } else {?><form method="post"> 
    <input type="hidden" name="id" value="<?= $student['id'] ?>"> 
    <label>Họ tên:</label> <input type="text" name="name" value="<?= $student['name'] ?>"><br> 
    <label>Email:</label> <input type="email" name="email" value="<?= $student['email'] ?>"><br> 
    <label>SĐT:</label> <input type="text" name="phone" value="<?= $student['phone'] ?>"><br> 
    <button type="submit">Cập nhật</button> 
    <a href="list_students.php" class="btn btn-secondary">
            Quay lại danh sách
    </a>


</form>
<?php } ?>
