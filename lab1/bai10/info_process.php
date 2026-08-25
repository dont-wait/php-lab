
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoten = htmlspecialchars(trim($_POST['hoten'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    echo '<h1>Thong tin da gui</h1>';
    echo "Ho ten: $hoten<br>";
    echo "Email: $email<br>";
    echo "Phone: $phone<br>";
} else {
    echo 'Phải gửi bằng POST';
}
