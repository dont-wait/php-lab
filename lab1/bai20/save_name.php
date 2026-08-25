<?php

$name = trim($_POST['name'] ?? '');

if ($name === '') {
    echo 'Vui lòng nhập tên trước khi lưu cookie.<br>';
    echo "<a href='name_form.html'>Quay lại</a>";
    exit;
}

setcookie('remembered_name', $name, time() + 3600, '/');
header('Location: remember_name.php');
exit;
