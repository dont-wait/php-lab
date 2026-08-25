<?php

$nInput = trim($_GET['n'] ?? '');

if ($nInput === '') {
    echo 'Vui lòng nhập số nguyên N.<br>';
    echo "<a href='/bai16/sum_form.html'>Quay lại</a>";
    exit;
}

$n = filter_var($nInput, FILTER_VALIDATE_INT);
if ($n === false || $n < 1) {
    echo 'Vui lòng nhập số nguyên N lớn hơn hoặc bằng 1.<br>';
    echo "<a href='sum_form.html'>Quay lại</a>";
    exit;
}

$total = 0;
for ($i = 1; $i <= $n; $i++) {
    $total += $i;
}

echo 'Tổng các số từ 1 đến '.htmlspecialchars($nInput).' là: '.$total.'<br>';
echo "<a href='sum_form.html'>Quay lại</a>";
