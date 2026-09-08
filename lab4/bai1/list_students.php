<?php

require 'connect.php';

$stmt = $conn->query('SELECT * FROM students');
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

require __DIR__ . '/header.php';
?>
<table class="table table-bordered table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>SĐT</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($students as $row) { ?>
            

        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>

            <td>
                <a
                    href="delete_student.php?id=<?= urlencode($row['id']) ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Bạn có chắc muốn xóa không?')"
                >
                    Xóa
                </a>
            </td>
            <td><a href="edit_student.php?id=<?= $row['id'] ?>">Sửa</a>    
            </td>
        </tr>

        <?php } ?>
    </tbody>
</table>

<a href="add_student.php" class="btn btn-primary">
    Thêm sinh viên
</a>

<?php require __DIR__ . '/footer.php'; ?>
