<?php

function toUppercase(string $value): string
{
    if (function_exists('mb_strtoupper')) {
        return mb_strtoupper($value, 'UTF-8');
    }

    return strtoupper($value);
}

$input = trim($_POST['text'] ?? '');

if ($input === '') {
    echo 'Vui lòng nhập chuỗi cần chuyển.<br>';
    echo "<a href='uppercase_form.html'>Quay lại</a>";
    exit;
}

echo 'Chuỗi sau khi viết hoa: '.htmlspecialchars(toUppercase($input)).'<br>';
echo "<a href='uppercase_form.html'>Quay lại</a>";
