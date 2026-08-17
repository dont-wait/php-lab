<?php

$savedName = trim($_COOKIE['remembered_name'] ?? '');

if ($savedName === '') {
    header('Location: name_form.html');
    exit;
}

echo 'Chào lại, <strong>'.htmlspecialchars($savedName).'</strong>!<br>';
echo "<a href='clear_name.php'>Xóa tên đã lưu</a>";
